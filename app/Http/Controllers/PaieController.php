<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\FichePaie;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Contrôleur pour la gestion de la paie (DS4 du CDC).
 * Flux : Saisie → CNSS/AGUIPE → PDF+QR → Notification.
 */
class PaieController extends Controller
{
    // ──────────────────────────────────────────────
    //  CÔTÉ EMPLOYEUR
    // ──────────────────────────────────────────────

    /**
     * Liste des fiches de paie générées.
     */
    public function indexEmployer(): View
    {
        $entreprise = Auth::user()->entreprise;
        $fiches = FichePaie::whereHas('employe', fn($q) => $q->where('entreprise_id', $entreprise->id))
            ->with(['employe.user', 'contrat'])
            ->latest()
            ->get();

        return view('employer.paie.index', compact('fiches'));
    }

    /**
     * Formulaire de génération de fiche de paie.
     */
    public function createEmployer(): View
    {
        $entreprise = Auth::user()->entreprise;
        $contrats = Contrat::where('entreprise_id', $entreprise->id)
            ->where('statut', Contrat::STATUS_ACTIVE)
            ->with('employe.user')
            ->get();

        return view('employer.paie.create', compact('contrats'));
    }

    /**
     * Génère la fiche de paie avec calcul CNSS/AGUIPE (CDC DS4).
     */
    public function storeEmployer(Request $request): RedirectResponse
    {
        $request->validate([
            'contrat_id' => 'required|exists:contrats,id',
            'mois' => 'required|date',
            'autres_deductions' => 'nullable|numeric|min:0',
        ]);

        $contrat = Contrat::findOrFail($request->contrat_id);

        if ($contrat->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        // CDC DS4 : CalcService — CNSS 5% et AGUIPE 1%
        $salaireBrut = $contrat->salaire_mensuel_brut;
        $cnss = round($salaireBrut * FichePaie::TAUX_CNSS, 2);
        $aguipe = round($salaireBrut * FichePaie::TAUX_AGUIPE, 2);
        $autresDeductions = $request->autres_deductions ?? 0;
        $salaireNet = $salaireBrut - $cnss - $aguipe - $autresDeductions;

        $fiche = FichePaie::create([
            'employe_id' => $contrat->employe_id,
            'contrat_id' => $contrat->id,
            'mois' => $request->mois,
            'salaire_brut' => $salaireBrut,
            'cnss' => $cnss,
            'aguipe' => $aguipe,
            'autres_deductions' => $autresDeductions,
            'salaire_net' => $salaireNet,
        ]);

        // CDC DS4 : Notification à l'employé par email
        try {
            \Illuminate\Support\Facades\Mail::to($contrat->employe->user->email)
                ->send(new \App\Mail\FichePaieGeneree($fiche));
        } catch (\Exception $e) {
            // On continue même si l'email échoue (pour ne pas bloquer la génération)
            \Illuminate\Support\Facades\Log::error("Erreur envoi email paie : " . $e->getMessage());
        }

        return redirect()->route('employer.paie.index')
            ->with('success', "Fiche de paie générée pour {$contrat->employe->user->full_name} — Net : " . number_format($salaireNet, 0, ',', ' ') . " GNF");
    }

    // ──────────────────────────────────────────────
    //  CÔTÉ EMPLOYÉ
    // ──────────────────────────────────────────────

    /**
     * Liste des bulletins de paie de l'employé.
     */
    public function indexEmployee(): View
    {
        $employe = Auth::user()->employe;
        $fiches = $employe->fichesPaie()->with('contrat')->latest()->get();

        return view('employee.paie.index', compact('fiches'));
    }

    // ──────────────────────────────────────────────
    //  PDF (DS4 : PDF+QR)
    // ──────────────────────────────────────────────

    /**
     * Télécharge la fiche de paie en PDF.
     */
    public function downloadPdf(FichePaie $fichePaie)
    {
        $user = Auth::user();

        // Sécurité : seul l'employé ou son employeur peut télécharger
        if ($user->hasRole('employe') && $fichePaie->employe_id !== $user->employe->id) {
            abort(403);
        }
        if ($user->hasRole('employeur') && $fichePaie->employe->entreprise_id !== $user->entreprise->id) {
            abort(403);
        }

        $pdf = Pdf::loadView('paie.pdf', ['fiche' => $fichePaie]);
        return $pdf->download("Bulletin_Paie_{$fichePaie->mois->format('Y_m')}_{$fichePaie->employe->numero_matricule}.pdf");
    }
}

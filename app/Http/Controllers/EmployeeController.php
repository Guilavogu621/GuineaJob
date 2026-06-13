<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\SignatureService;

/**
 * Contrôleur pour la gestion de l'espace Employé.
 * Gère le dashboard personnel et la signature des contrats.
 */
class EmployeeController extends Controller
{
    /**
     * Génère et télécharge le contrat en PDF.
     */
    public function downloadPdf(Contrat $contract)
    {
        $user = Auth::user();

        // SECURITÉ : Seul l'employé propriétaire du contrat peut le télécharger
        if ($contract->employe_id !== $user->employe->id) {
            abort(403, 'Action non autorisée.');
        }

        // Si un PDF signé existe déjà sur le disque, on le sert directement
        if ($contract->document_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($contract->document_path)) {
            return response()->download(storage_path('app/public/' . $contract->document_path));
        }

        // Sinon (cas des anciens contrats ou brouillons), on génère à la volée
        $pdf = Pdf::loadView('contracts.pdf', compact('contract'));
        return $pdf->download('Contrat_GuineJob_' . $contract->numero_contrat . '.pdf');
    }
    /**
     * Affiche le tableau de bord de l'employé (CDC Section 7.4).
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $employe = $user->employe;

        // CDC 7.4 : Solde de congés avec barre de progression visuelle
        $soldeConges = CongeController::calculerSoldeConges($employe);
        $moisTravailles = \Carbon\Carbon::parse($employe->date_embauche)->diffInMonths(now());
        $joursAcquis = round($moisTravailles * 2.5, 1);
        $joursUtilises = $employe->conges()->whereIn('statut', [\App\Models\Conge::STATUS_APPROVED])->where('type_conge', 'annuel')->sum('jours_deduits');
        $progressPct = $joursAcquis > 0 ? min(100, round(($joursUtilises / $joursAcquis) * 100)) : 0;

        // CDC 7.4 : Liste des 3 dernières fiches de paie
        $derniersBulletins = $employe->fichesPaie()->latest()->take(3)->get();

        // Données pour le Graphique (Évolution du salaire net sur 6 mois)
        $historiqueSalaires = $employe->fichesPaie()
            ->latest()
            ->take(6)
            ->get()
            ->reverse()
            ->mapWithKeys(function($f) {
                // mois est déjà casté en date (Carbon instance)
                $label = $f->mois->translatedFormat('M Y');
                return [ucfirst($label) => $f->salaire_net];
            })->toArray();

        return view('employee.dashboard', compact('user', 'employe', 'soldeConges', 'joursAcquis', 'joursUtilises', 'progressPct', 'derniersBulletins', 'historiqueSalaires'));
    }

    /**
     * Affiche le contrat de travail pour consultation et signature.
     */
    public function showContract(): View|RedirectResponse
    {
        $user = Auth::user();
        $employe = $user->employe;

        if (!$employe) {
            return back()->with('error', 'Aucune fiche employé trouvée pour votre compte.');
        }

        // Récupère le contrat le plus récent (exclut les brouillons non envoyés)
        $contract = $employe->contrats()
                            ->where('statut', '!=', Contrat::STATUS_DRAFT)
                            ->latest()
                            ->first();

        return view('employee.contracts.show', compact('user', 'employe', 'contract'));
    }

    /**
     * Procède à la signature électronique finale du contrat par l'employé avec preuve OpenSSL.
     */
    public function signContractEmployee(Request $request, Contrat $contract, SignatureService $signatureService): RedirectResponse
    {
        // VERIFICATION EXPERT : L'employeur doit avoir signé en premier pour la validité légale
        if (!$contract->signed_at_employer) {
            return back()->with('error', 'L\'employeur doit signer le contrat avant vous.');
        }

        // 1. Mettre à jour les métadonnées de signature
        $contract->update([
            'statut' => Contrat::STATUS_ACTIVE,
            'signed_at_employee' => now(),
            'ip_employee' => $request->ip(),
        ]);

        // 2. Générer le PDF final (Contenant les deux signatures)
        $pdfPath = 'contrats/Contrat_' . $contract->numero_contrat . '.pdf';
        $pdf = Pdf::loadView('contracts.pdf', compact('contract'));
        \Illuminate\Support\Facades\Storage::disk('public')->put($pdfPath, $pdf->output());

        // 3. Signer cryptographiquement le PDF final
        $signatureService->signDocument($pdfPath);

        // 4. Mettre à jour le chemin
        $contract->update(['document_path' => $pdfPath]);

        return back()->with('success', 'Félicitations ! Votre contrat est signé, actif et sécurisé cryptographiquement.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Employe;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Contrôleur pour la gestion des congés (DS3 du CDC).
 * Flux : Soumission → Calcul solde → Décision → Notification.
 */
class CongeController extends Controller
{
    // ──────────────────────────────────────────────
    //  CÔTÉ EMPLOYÉ
    // ──────────────────────────────────────────────

    /**
     * Liste des demandes de congé de l'employé connecté.
     */
    public function indexEmployee(): View
    {
        $employe = Auth::user()->employe;
        $conges = $employe->conges()->latest()->get();

        return view('employee.conges.index', compact('conges'));
    }

    /**
     * Formulaire de demande de congé.
     */
    public function createEmployee(): View
    {
        return view('employee.conges.create');
    }

    /**
     * Enregistre une nouvelle demande de congé.
     * CDC DS3 : Soumission → Calcul solde → Enregistrement.
     */
    public function storeEmployee(Request $request): RedirectResponse
    {
        $request->validate([
            'type_conge' => 'required|in:annuel,maladie,maternite,paternite,sans_solde',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'motif' => 'required|string|in:Maladie,Personnel,Familial,Formation,Autre',
        ]);

        $employe = Auth::user()->employe;

        // Calcul automatique des jours ouvrables
        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = Carbon::parse($request->date_fin);
        $joursOuvrables = $this->calculerJoursOuvrables($dateDebut, $dateFin);

        // Vérification du solde pour les congés annuels uniquement
        if ($request->type_conge === 'annuel') {
            $solde = $this->calculerSoldeConges($employe);

            if ($joursOuvrables > $solde) {
                return back()->withErrors(['date_fin' => "Solde insuffisant. Vous avez {$solde} jours restants mais demandez {$joursOuvrables} jours."])->withInput();
            }
        }

        Conge::create([
            'employe_id' => $employe->id,
            'type_conge' => $request->type_conge,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'jours_deduits' => $joursOuvrables,
            'motif' => $request->motif,
            'statut' => \App\Models\Conge::STATUS_PENDING,
        ]);

        return redirect()->route('employee.conges.index')
            ->with('success', "Demande de congé soumise ({$joursOuvrables} jours ouvrables). En attente de validation.");
    }

    // ──────────────────────────────────────────────
    //  CÔTÉ EMPLOYEUR
    // ──────────────────────────────────────────────

    /**
     * Liste des demandes de congé des employés de l'entreprise.
     */
    public function indexEmployer(): View
    {
        $entreprise = Auth::user()->entreprise;
        $conges = Conge::whereHas('employe', function ($query) use ($entreprise) {
            $query->where('entreprise_id', $entreprise->id);
        })->with(['employe.user', 'validePar'])->latest()->get();

        return view('employer.conges.index', compact('conges'));
    }

    /**
     * Valide une demande de congé.
     * CDC : valide_par FK → users.
     */
    public function approveConge(Conge $conge): RedirectResponse
    {
        if ($conge->employe->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $conge->update([
            'statut' => \App\Models\Conge::STATUS_APPROVED,
            'valide_par' => Auth::id(),
        ]);

        // Notification Email (DS3)
        try {
            \Illuminate\Support\Facades\Mail::to($conge->employe->user->email)
                ->send(new \App\Mail\CongeStatutMisAJour($conge));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur email congé : " . $e->getMessage());
        }

        return back()->with('success', "Congé approuvé pour {$conge->employe->user->full_name}.");
    }

    /**
     * Refuse une demande de congé.
     */
    public function rejectConge(Request $request, Conge $conge): RedirectResponse
    {
        if ($conge->employe->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $request->validate(['reponse_employeur' => 'required|string|min:5']);

        $conge->update([
            'statut' => \App\Models\Conge::STATUS_REJECTED,
            'reponse_employeur' => $request->reponse_employeur,
            'valide_par' => Auth::id(),
        ]);

        // Notification Email (DS3)
        try {
            \Illuminate\Support\Facades\Mail::to($conge->employe->user->email)
                ->send(new \App\Mail\CongeStatutMisAJour($conge));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur email congé : " . $e->getMessage());
        }

        return back()->with('success', "Congé refusé pour {$conge->employe->user->full_name}.");
    }

    // ──────────────────────────────────────────────
    //  UTILITAIRES
    // ──────────────────────────────────────────────

    /**
     * Calcule le solde de congés annuels restants.
     * Droit guinéen : 2.5 jours ouvrables / mois travaillé.
     */
    public static function calculerSoldeConges(Employe $employe): float
    {
        $moisTravailles = Carbon::parse($employe->date_embauche)->diffInMonths(now());
        $joursAcquis = round($moisTravailles * 2.5, 1);
        $joursUtilises = $employe->conges()->where('statut', \App\Models\Conge::STATUS_APPROVED)->where('type_conge', 'annuel')->sum('jours_deduits');

        return max(0, $joursAcquis - $joursUtilises);
    }

    /**
     * Calcule le nombre de jours ouvrables entre deux dates (exclut samedi et dimanche).
     */
    private function calculerJoursOuvrables(Carbon $debut, Carbon $fin): int
    {
        $jours = 0;
        $current = $debut->copy();

        while ($current->lte($fin)) {
            if (!$current->isWeekend()) {
                $jours++;
            }
            $current->addDay();
        }

        return $jours;
    }
}

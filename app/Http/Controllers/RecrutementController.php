<?php

namespace App\Http\Controllers;

use App\Models\OffreEmploi;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RecrutementController extends Controller
{
    /**
     * Liste des offres d'emploi de l'entreprise.
     */
    public function index(): View
    {
        $entreprise = Auth::user()->entreprise;
        $offres = $entreprise->offresEmploi()->withCount('candidatures')->latest()->get();
        
        return view('employer.recrutement.index', compact('offres'));
    }

    /**
     * Formulaire de création d'une offre.
     */
    public function create(): View
    {
        return view('employer.recrutement.create');
    }

    /**
     * Enregistre une nouvelle offre d'emploi.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'competences_requises' => 'nullable|string',
            'lieu' => 'required|string|max:100',
            'type_contrat' => 'required|in:CDI,CDD,Stage,Prestation',
            'salaire_range' => 'nullable|string|max:100',
            'date_expiration' => 'nullable|date|after:today',
        ]);

        Auth::user()->entreprise->offresEmploi()->create([
            'titre' => $request->titre,
            'description' => $request->description,
            'competences_requises' => $request->competences_requises,
            'lieu' => $request->lieu,
            'type_contrat' => $request->type_contrat,
            'salaire_range' => $request->salaire_range,
            'date_expiration' => $request->date_expiration,
            'statut' => \App\Models\OffreEmploi::STATUS_PUBLISHED,
        ]);

        return redirect()->route('employer.recrutement.index')->with('success', 'Offre d\'emploi publiée avec succès.');
    }

    /**
     * Affiche les candidatures pour une offre.
     */
    public function applications(OffreEmploi $offre): View
    {
        if ($offre->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $candidatures = $offre->candidatures()->with('user')->latest()->get();
        
        return view('employer.recrutement.applications', compact('offre', 'candidatures'));
    }

    /**
     * Met à jour le statut d'une candidature.
     */
    public function updateApplicationStatus(Request $request, Candidature $candidature): RedirectResponse
    {
        if ($candidature->offre->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $request->validate([
            'statut' => 'required|in:en_attente,retenu,rejete,entretien,embauche',
            'note_employeur' => 'nullable|string',
        ]);

        $candidature->update([
            'statut' => $request->statut,
            'note_employeur' => $request->note_employeur,
        ]);

        return back()->with('success', 'Statut de la candidature mis à jour.');
    }

    /**
     * Supprime une offre d'emploi.
     */
    public function destroy(OffreEmploi $offre): RedirectResponse
    {
        if ($offre->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $offre->delete();

        return redirect()->route('employer.recrutement.index')->with('success', 'Offre d\'emploi supprimée.');
    }
}

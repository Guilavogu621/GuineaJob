<?php

namespace App\Http\Controllers;

use App\Models\OffreEmploi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateController extends Controller
{
    /**
     * Affiche les offres d'emploi actives pour le candidat dans son espace.
     */
    public function jobs(Request $request): View
    {
        $query = OffreEmploi::with('entreprise')->where('statut', \App\Models\OffreEmploi::STATUS_PUBLISHED);

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type_contrat', $request->type);
        }

        $offres = $query->latest()->paginate(10);

        return view('candidate.jobs.index', compact('offres'));
    }

    /**
     * Affiche les détails d'une offre dans l'espace candidat.
     */
    public function show(OffreEmploi $offre): View
    {
        if ($offre->statut !== \App\Models\OffreEmploi::STATUS_PUBLISHED) {
            abort(404);
        }

        $offre->increment('vues');

        // Récupérer la candidature de l'utilisateur pour cette offre s'il y en a une
        $candidatureExistante = \App\Models\Candidature::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->where('offre_emploi_id', $offre->id)
            ->first();

        return view('candidate.jobs.show', compact('offre', 'candidatureExistante'));
    }

    /**
     * Formulaire pour postuler depuis l'espace candidat.
     */
    public function apply(OffreEmploi $offre): View
    {
        if ($offre->statut !== \App\Models\OffreEmploi::STATUS_PUBLISHED) {
            abort(404);
        }

        // Si déjà postulé, rediriger
        $candidatureExistante = \App\Models\Candidature::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->where('offre_emploi_id', $offre->id)
            ->first();
            
        if ($candidatureExistante) {
            return redirect()->route('candidate.jobs.show', $offre)->with('info', 'Vous avez déjà postulé à cette offre.');
        }

        return view('candidate.jobs.apply', compact('offre'));
    }

    /**
     * Enregistre la candidature depuis l'espace candidat.
     */
    public function storeApplication(Request $request, OffreEmploi $offre): \Illuminate\Http\RedirectResponse
    {
        if ($offre->statut !== \App\Models\OffreEmploi::STATUS_PUBLISHED) {
            abort(404);
        }

        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'lettre_motivation' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $cvPath = $request->file('cv')->store('candidatures/cvs', 'public');
        $lmPath = $request->hasFile('lettre_motivation')
            ? $request->file('lettre_motivation')->store('candidatures/lettres', 'public')
            : null;

        \App\Models\Candidature::create([
            'offre_emploi_id' => $offre->id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'cv_path' => $cvPath,
            'lettre_motivation_path' => $lmPath,
            'commentaire_candidat' => $request->commentaire,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('candidate.jobs.index')->with('success', 'Votre candidature a été envoyée avec succès !');
    }
}

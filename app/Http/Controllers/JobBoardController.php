<?php

namespace App\Http\Controllers;

use App\Models\OffreEmploi;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JobBoardController extends Controller
{
    /**
     * Affiche toutes les offres d'emploi publiques.
     */
    public function index(Request $request): View
    {
        $query = OffreEmploi::with('entreprise')->where('statut', \App\Models\OffreEmploi::STATUS_PUBLISHED);

        // Filtres (Pro Max)
        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type_contrat', $request->type);
        }

        $offres = $query->latest()->paginate(10);

        return view('jobboard.index', compact('offres'));
    }

    /**
     * Affiche les détails d'une offre.
     */
    public function show(OffreEmploi $offre): View
    {
        if ($offre->statut !== \App\Models\OffreEmploi::STATUS_PUBLISHED) {
            abort(404);
        }

        $offre->increment('vues');

        return view('jobboard.show', compact('offre'));
    }

    /**
     * Formulaire pour postuler.
     */
    public function apply(OffreEmploi $offre): View
    {
        if (!Auth::user()->isCandidat()) {
            abort(403, 'Accès réservé aux candidats.');
        }

        if ($offre->statut !== \App\Models\OffreEmploi::STATUS_PUBLISHED) {
            abort(404);
        }

        return view('jobboard.apply', compact('offre'));
    }

    /**
     * Enregistre la candidature.
     */
    public function storeApplication(Request $request, OffreEmploi $offre): RedirectResponse
    {
        if (!Auth::user()->isCandidat()) {
            abort(403, 'Accès réservé aux candidats.');
        }

        if ($offre->statut !== \App\Models\OffreEmploi::STATUS_PUBLISHED) {
            abort(404);
        }

        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            'lettre_motivation' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        // Stockage des fichiers
        $cvPath = $request->file('cv')->store('candidatures/cvs', 'public');
        $lmPath = $request->hasFile('lettre_motivation')
            ? $request->file('lettre_motivation')->store('candidatures/lettres', 'public')
            : null;

        Candidature::create([
            'offre_emploi_id' => $offre->id,
            'user_id' => Auth::id(),
            'cv_path' => $cvPath,
            'lettre_motivation_path' => $lmPath,
            'commentaire_candidat' => $request->commentaire,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('jobboard.index')->with('success', 'Votre candidature a été envoyée avec succès !');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AppelOffre;
use App\Models\PropositionOffre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AppelOffreController extends Controller
{
    /**
     * Liste publique de tous les appels d'offres.
     */
    public function index(Request $request): View
    {
        $query = AppelOffre::with('entreprise')->where('statut', \App\Models\AppelOffre::STATUS_PUBLISHED);

        if ($request->filled('secteur')) {
            $query->where('secteur_activite', $request->secteur);
        }

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        $appels = $query->latest()->paginate(10);

        return view('appels.index', compact('appels'));
    }

    /**
     * Liste des appels d'offres de l'entreprise connectée.
     */
    public function mesAppels(): View
    {
        $appels = Auth::user()->entreprise->appelsOffres()->withCount('propositions')->latest()->get();
        return view('employer.appels.index', compact('appels'));
    }

    /**
     * Formulaire de création d'un appel d'offre.
     */
    public function create(): View
    {
        return view('employer.appels.create');
    }

    /**
     * Enregistre un nouvel appel d'offre.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'secteur_activite' => 'required|string',
            'budget_estime' => 'nullable|string',
            'date_limite' => 'required|date|after:today',
            'document_cctp' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB
        ]);

        $path = $request->hasFile('document_cctp')
            ? $request->file('document_cctp')->store('appels_offres/cctp', 'public')
            : null;

        Auth::user()->entreprise->appelsOffres()->create([
            'titre' => $request->titre,
            'description' => $request->description,
            'secteur_activite' => $request->secteur_activite,
            'budget_estime' => $request->budget_estime,
            'lieu_execution' => $request->lieu_execution,
            'date_limite' => $request->date_limite,
            'document_cctp' => $path,
            'statut' => \App\Models\AppelOffre::STATUS_PUBLISHED
        ]);

        return redirect()->route('employer.appels.index')->with('success', 'Appel d\'offre publié avec succès.');
    }

    /**
     * Affiche les détails d'un appel d'offre.
     */
    public function show(AppelOffre $appel): View
    {
        $appel->increment('vues');
        return view('appels.show', compact('appel'));
    }

    /**
     * Soumettre une proposition (B2B).
     */
    public function submitProposal(Request $request, AppelOffre $appel): RedirectResponse
    {
        $user = Auth::user();

        if (!$user->isPrestataire()) {
            abort(403, 'Accès réservé aux prestataires.');
        }

        if (!$user->entreprise) {
            return back()->with('error', "Votre compte prestataire doit être rattaché à une entreprise pour soumettre une proposition.");
        }

        $request->validate([
            'montant_propose' => 'required|numeric|min:0',
            'delai_execution' => 'required|string',
            'document_proposition' => 'required|file|mimes:pdf|max:10240',
        ]);

        PropositionOffre::create([
            'appel_offre_id' => $appel->id,
            'entreprise_prestataire_id' => $user->entreprise->id,
            'montant_propose' => $request->montant_propose,
            'delai_execution' => $request->delai_execution,
            'message_accompagnement' => $request->message_accompagnement,
            'document_proposition' => $request->file('document_proposition')->store('propositions/documents', 'public'),
            'statut' => 'en_attente'
        ]);

        return redirect()->route('appels.show', $appel)->with('success', 'Votre proposition a été envoyée.');
    }

    /**
     * Voir les propositions reçues pour un appel d'offre.
     */
    public function propositions(AppelOffre $appel): View
    {
        if ($appel->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $propositions = $appel->propositions()->with('prestataire')->latest()->get();
        return view('employer.appels.propositions', compact('appel', 'propositions'));
    }
}

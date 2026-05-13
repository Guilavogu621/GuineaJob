<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employe;
use App\Models\Contrat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Contrôleur pour la gestion de l'espace Employeur.
 * Gère les employés, les contrats et les paramètres de compte.
 */
class EmployerController extends Controller
{
    /**
     * Génère et télécharge le contrat en PDF.
     */
    public function downloadPdf(Contrat $contract)
    {
        if ($contract->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $pdf = Pdf::loadView('contracts.pdf', compact('contract'));
        return $pdf->download('Contrat_Expert_' . $contract->numero_contrat . '.pdf');
    }
    /**
     * Dashboard de l'employeur.
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $entreprise = $user->entreprise;
        return view('employer.dashboard', compact('user', 'entreprise'));
    }

    /**
     * Affiche le formulaire de changement de mot de passe.
     */
    public function showChangePassword(): View
    {
        return view('auth.change-password');
    }

    /**
     * Met à jour le mot de passe de l'utilisateur.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect('/employer/dashboard')->with('success', 'Votre mot de passe a été mis à jour avec succès.');
    }

    /**
     * Liste tous les employés de l'entreprise.
     */
    public function indexEmployees(): View
    {
        $entreprise = Auth::user()->entreprise;
        $employees = $entreprise->employes()->with('user')->get();
        
        return view('employer.employees.index', compact('employees'));
    }

    /**
     * Formulaire de création d'un employé.
     */
    public function createEmployee(): View
    {
        return view('employer.employees.create');
    }

    /**
     * Enregistre un nouvel employé et crée son compte utilisateur.
     */
    public function storeEmployee(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'poste' => 'required|string|max:100',
            'date_embauche' => 'required|date',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:100',
            'genre' => 'required|in:Masculin,Féminin',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'type_contrat' => 'required|in:CDI,CDD',
            'salaire_base' => 'required|numeric|min:0',
        ]);

        $result = DB::transaction(function () use ($request) {
            $tempPassword = Str::random(16);
            
            // Création du compte utilisateur
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($tempPassword),
                'role' => 'employe',
                'must_change_password' => true,
            ]);

            // Création de la fiche employé (le matricule est généré par le modèle)
            $employe = Employe::create([
                'user_id' => $user->id,
                'entreprise_id' => Auth::user()->entreprise->id,
                'poste' => $request->poste,
                'date_embauche' => $request->date_embauche,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'genre' => $request->genre,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'type_contrat' => $request->type_contrat,
                'salaire_base' => $request->salaire_base,
            ]);

            return ['user' => $user, 'matricule' => $employe->numero_matricule, 'tempPassword' => $tempPassword];
        });

        return redirect()->route('employer.employees.index')
            ->with('success', "Employé créé avec succès. Matricule : {$result['matricule']}")
            ->with('temp_password', $result['tempPassword'])
            ->with('new_employee_email', $result['user']->email);
    }

    /**
     * Formulaire de modification d'un employé.
     */
    public function editEmployee(Employe $employe): View
    {
        if ($employe->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        return view('employer.employees.edit', compact('employe'));
    }

    /**
     * Met à jour les informations d'un employé.
     */
    public function updateEmployee(Request $request, Employe $employe): RedirectResponse
    {
        if ($employe->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'poste' => 'required|string|max:100',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'type_contrat' => 'required|in:CDI,CDD',
            'salaire_base' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $employe) {
            $employe->user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
            ]);

            $employe->update([
                'poste' => $request->poste,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'type_contrat' => $request->type_contrat,
                'salaire_base' => $request->salaire_base,
            ]);
        });

        return redirect()->route('employer.employees.index')
            ->with('success', "Les informations de l'employé {$employe->numero_matricule} ont été mises à jour.");
    }

    /**
     * Liste des contrats de l'entreprise.
     */
    public function indexContracts(): View
    {
        $entreprise = Auth::user()->entreprise;
        $contracts = $entreprise->contrats()->with('employe.user')->latest()->get();
        return view('employer.contracts.index', compact('contracts'));
    }

    /**
     * Formulaire de création d'un contrat.
     */
    public function createContract(): View
    {
        $entreprise = Auth::user()->entreprise;
        $employees = $entreprise->employes()->with('user')->get();
        return view('employer.contracts.create', compact('employees'));
    }

    /**
     * Génère un nouveau contrat de travail.
     */
    public function storeContract(Request $request): RedirectResponse
    {
        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'type_contrat' => 'required|in:CDI,CDD,Stage,Prestation',
            'date_debut' => 'required|date',
            'date_fin' => 'required_if:type_contrat,CDD,Stage|nullable|date|after:date_debut',
            'salaire_mensuel_brut' => 'required|numeric|min:0',
            'periode_essai' => 'nullable|string|max:100',
            'clauses_specifiques' => 'nullable|string',
            'avantages' => 'nullable|array',
        ], [
            'required' => 'Le champ :attribute est obligatoire.',
            'required_if' => 'La :attribute est obligatoire pour un contrat de type :value.',
            'exists' => 'L\'employé sélectionné n\'existe pas.',
            'after' => 'La date de fin doit être après la date de début.',
        ]);

        $entreprise = Auth::user()->entreprise;
        $employe = $entreprise->employes()->find($request->employe_id);

        if (!$employe) {
            return back()->withErrors(['employe_id' => 'Accès refusé : cet employé n\'appartient pas à votre structure.']);
        }

        // Création du contrat (le numéro est généré par le modèle)
        $contract = Contrat::create([
            'employe_id' => $employe->id,
            'entreprise_id' => $entreprise->id,
            'type_contrat' => $request->type_contrat,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'salaire_mensuel_brut' => $request->salaire_mensuel_brut,
            'periode_essai' => $request->periode_essai,
            'clauses_specifiques' => $request->clauses_specifiques,
            'avantages' => $request->avantages,
            'statut' => Contrat::STATUS_DRAFT,
        ]);

        return redirect()->route('employer.contracts.index')
            ->with('success', "Contrat {$contract->numero_contrat} généré avec succès.");
    }

    /**
     * Envoie le contrat à l'employé.
     */
    public function sendContract(Contrat $contract): RedirectResponse
    {
        $contract->update([
            'statut' => Contrat::STATUS_SENT,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Le contrat a été envoyé à l\'employé pour consultation.');
    }

    /**
     * Affiche le contrat pour consultation et signature par l'employeur.
     */
    public function showContract(Contrat $contract): View
    {
        if ($contract->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $user = Auth::user();
        $employe = $contract->employe;

        return view('employer.contracts.show', compact('contract', 'user', 'employe'));
    }

    /**
     * Formulaire de modification d'un contrat (Brouillon/Envoyé).
     */
    public function editContract(Contrat $contract): View
    {
        if ($contract->entreprise_id !== Auth::user()->entreprise->id) { abort(403); }
        
        if ($contract->isSignedByEmployee()) {
            return back()->with('error', 'Un contrat signé par l\'employé ne peut plus être modifié.');
        }

        $entreprise = Auth::user()->entreprise;
        $employees = $entreprise->employes()->with('user')->get();
        return view('employer.contracts.edit', compact('contract', 'employees'));
    }

    /**
     * Met à jour les informations du contrat.
     */
    public function updateContract(Request $request, Contrat $contract): RedirectResponse
    {
        if ($contract->entreprise_id !== Auth::user()->entreprise->id) { abort(403); }

        $request->validate([
            'type_contrat' => 'required|in:CDI,CDD,Stage,Prestation',
            'date_debut' => 'required|date',
            'date_fin' => 'required_if:type_contrat,CDD,Stage|nullable|date|after:date_debut',
            'salaire_mensuel_brut' => 'required|numeric|min:0',
            'periode_essai' => 'nullable|string|max:100',
            'clauses_specifiques' => 'nullable|string',
            'avantages' => 'nullable|array',
        ]);

        $contract->update([
            'type_contrat' => $request->type_contrat,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'salaire_mensuel_brut' => $request->salaire_mensuel_brut,
            'periode_essai' => $request->periode_essai,
            'clauses_specifiques' => $request->clauses_specifiques,
            'avantages' => $request->avantages,
            'statut' => Contrat::STATUS_DRAFT,
            'signed_at_employer' => null,
            'signed_at_employee' => null,
        ]);

        return redirect()->route('employer.contracts.index')->with('success', 'Contrat mis à jour et repassé en brouillon.');
    }

    /**
     * Affiche le formulaire de rupture/résiliation de contrat.
     */
    public function showTerminate(Contrat $contract): View
    {
        if ($contract->entreprise_id !== Auth::user()->entreprise->id) { abort(403); }

        return view('employer.contracts.terminate', compact('contract'));
    }

    /**
     * Traite la rupture légale du contrat.
     */
    public function processTerminate(Request $request, Contrat $contract): RedirectResponse
    {
        if ($contract->entreprise_id !== Auth::user()->entreprise->id) { abort(403); }

        $request->validate([
            'type_resiliation' => 'required|string',
            'date_resiliation' => 'required|date',
            'motif_resiliation' => 'required|string|min:10',
        ]);

        // VERIFICATION EXPERT : Règles CDD
        if ($contract->type_contrat === 'CDD' && $contract->statut === Contrat::STATUS_ACTIVE) {
            $motifsAutorises = [
                Contrat::RUPTURE_ACCORD,
                Contrat::RUPTURE_FAUTE_GRAVE,
                'Force majeure',
                'Inaptitude médicale',
                'Embauche en CDI'
            ];
            
            if (!in_array($request->type_resiliation, $motifsAutorises)) {
                return back()->with('error', 'Un CDD actif ne peut être rompu que pour des motifs légaux spécifiques (Accord, Faute grave, Embauche CDI, etc.).');
            }
        }

        $contract->update([
            'statut' => Contrat::STATUS_CANCELLED,
            'type_resiliation' => $request->type_resiliation,
            'motif_resiliation' => $request->motif_resiliation,
            'date_resiliation' => $request->date_resiliation,
            'resilie_at' => now(),
        ]);

        return redirect()->route('employer.contracts.index')->with('success', 'La rupture du contrat a été enregistrée conformément aux dispositions légales.');
    }

    /**
     * Signature électronique par l'employeur.
     */
    public function signContractEmployer(Request $request, Contrat $contract): RedirectResponse
    {
        if ($contract->entreprise_id !== Auth::user()->entreprise->id) {
            abort(403);
        }

        $contract->update([
            'statut' => Contrat::STATUS_SIGNED_EMPLOYER,
            'signed_at_employer' => now(),
            'ip_employer' => $request->ip(),
        ]);

        return redirect()->route('employer.contracts.index')->with('success', 'Contrat signé numériquement avec succès.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employe;
use App\Models\Contrat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class EmployerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $entreprise = $user->entreprise;
        return view('employer.dashboard', compact('user', 'entreprise'));
    }

    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
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

    // --- Gestion des employés ---

    public function indexEmployees()
    {
        $entreprise = Auth::user()->entreprise;
        $employees = $entreprise->employes()->with('user')->get();
        
        return view('employer.employees.index', compact('employees'));
    }

    public function createEmployee()
    {
        return view('employer.employees.create');
    }

    public function storeEmployee(Request $request)
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

        // Utilisation d'une transaction pour garantir l'intégrité des données
        $result = DB::transaction(function () use ($request) {
            // 1. Création de l'utilisateur
            $tempPassword = Str::random(16);
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($tempPassword),
                'role' => 'employe',
                'must_change_password' => true,
            ]);

            // 2. Création de la fiche employé
            $matricule = 'EMP-' . strtoupper(Str::random(6));
            Employe::create([
                'user_id' => $user->id,
                'entreprise_id' => Auth::user()->entreprise->id,
                'poste' => $request->poste,
                'date_embauche' => $request->date_embauche,
                'numero_matricule' => $matricule,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'genre' => $request->genre,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'type_contrat' => $request->type_contrat,
                'salaire_base' => $request->salaire_base,
            ]);

            return ['user' => $user, 'matricule' => $matricule, 'tempPassword' => $tempPassword];
        });

        return redirect()->route('employer.employees.index')
            ->with('success', "Employé créé avec succès. Matricule : {$result['matricule']}")
            ->with('temp_password', $result['tempPassword'])
            ->with('new_employee_email', $result['user']->email);
    }

    // --- Gestion des contrats (GUIN-2) ---

    public function indexContracts()
    {
        $entreprise = Auth::user()->entreprise;
        $contracts = $entreprise->contrats()->with('employe.user')->latest()->get();
        return view('employer.contracts.index', compact('contracts'));
    }

    public function createContract()
    {
        $entreprise = Auth::user()->entreprise;
        $employees = $entreprise->employes()->with('user')->get();
        return view('employer.contracts.create', compact('employees'));
    }

    public function storeContract(Request $request)
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
            'date' => 'La date saisie n\'est pas valide.',
            'after' => 'La date de fin doit être après la date de début.',
            'numeric' => 'Le salaire doit être un nombre.',
        ], [
            'employe_id' => 'employé',
            'type_contrat' => 'type de contrat',
            'date_debut' => 'date de début',
            'date_fin' => 'date de fin',
            'salaire_mensuel_brut' => 'salaire mensuel brut',
        ]);

        $entreprise = Auth::user()->entreprise;

        // VERIFICATION EXPERT : L'employé appartient-il bien à cette entreprise ?
        $employe = $entreprise->employes()->find($request->employe_id);
        if (!$employe) {
            return back()->withErrors(['employe_id' => 'Action non autorisée. Cet employé ne fait pas partie de votre entreprise.']);
        }

        // Génération d'un numéro de contrat unique (Ex: CTR-2026-XXXX)
        $numero = 'CTR-' . date('Y') . '-' . strtoupper(Str::random(6));

        $contract = Contrat::create([
            'employe_id' => $employe->id,
            'entreprise_id' => $entreprise->id,
            'numero_contrat' => $numero,
            'type_contrat' => $request->type_contrat,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'salaire_mensuel_brut' => $request->salaire_mensuel_brut,
            'periode_essai' => $request->periode_essai,
            'clauses_specifiques' => $request->clauses_specifiques,
            'avantages' => $request->avantages,
            'statut' => Contrat::STATUS_DRAFT,
        ]);

        return redirect()->route('employer.contracts.index')->with('success', "Contrat {$numero} généré avec succès.");
    }

    public function sendContract(Contrat $contract)
    {
        $contract->update([
            'statut' => Contrat::STATUS_SENT,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Le contrat a été envoyé à l\'employé pour consultation.');
    }

    public function signContractEmployer(Request $request, Contrat $contract)
    {
        $contract->update([
            'statut' => Contrat::STATUS_SIGNED_EMPLOYER,
            'signed_at_employer' => now(),
            'ip_employer' => $request->ip(),
        ]);

        return back()->with('success', 'Contrat signé avec succès par l\'employeur.');
    }
}

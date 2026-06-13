<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Entreprise::with('user');

        // Recherche par raison sociale ou email gérant
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('raison_sociale', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('email', 'like', "%{$search}%")
                        ->orWhere('nom', 'like', "%{$search}%");
                  });
            });
        }

        $entreprises = $query->latest()->get();

        // CDC 7.2 : KPIs dynamiques
        $totalEntreprises = Entreprise::count();
        $totalEmployes = \App\Models\Employe::count();
        $contratsDuMois = \App\Models\Contrat::whereMonth('created_at', now()->month)->count();
        $masseSalarialeGlobale = \App\Models\Contrat::where('statut', \App\Models\Contrat::STATUS_ACTIVE)->sum('salaire_mensuel_brut');

        // Chart Data
        $contractsByStatus = \App\Models\Contrat::selectRaw('statut, count(*) as count')
            ->groupBy('statut')
            ->pluck('count', 'statut')
            ->toArray();

        $entreprisesParSecteur = Entreprise::selectRaw('secteur, count(*) as count')
            ->groupBy('secteur')
            ->pluck('count', 'secteur')
            ->toArray();

        return view('admin.dashboard', compact(
            'entreprises',
            'totalEntreprises',
            'totalEmployes',
            'contratsDuMois',
            'masseSalarialeGlobale',
            'contractsByStatus',
            'entreprisesParSecteur'
        ));
    }

    public function create()
    {
        return view('admin.create-employer');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'raison_sociale' => 'required|string|max:150',
            'secteur' => 'required|string|max:100',
        ]);

        // Générer un mot de passe temporaire
        $plainPassword = \Illuminate\Support\Str::random(10);

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($plainPassword),
            'role' => 'employeur',
            'must_change_password' => true,
        ]);

        // Assigner le rôle Spatie
        $user->assignRole('employeur');

        // Création de l'entreprise
        Entreprise::create([
            'user_id' => $user->id,
            'raison_sociale' => $request->raison_sociale,
            'secteur' => $request->secteur,
        ]);

        // Envoi de l'email avec le mot de passe
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\EmployeurCree($user, $plainPassword));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur envoi email Admin -> Employeur : " . $e->getMessage());
        }

        return redirect()->route('admin.dashboard')->with('success', 'Employeur créé avec succès. Un email contenant ses accès lui a été envoyé.');
    }

    // --- Gestion des Rôles (Epic : GUIN-1) ---

    public function listUsers()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // On synchronise le rôle Spatie
        $user->syncRoles([$request->role]);

        // On met à jour le champ role legacy pour la compatibilité
        $user->update(['role' => $request->role]);

        return back()->with('success', "Le rôle de {$user->full_name} a été mis à jour.");
    }

    // --- Gestion des Contrats (Vue Globale) ---

    public function listContracts(Request $request)
    {
        // L'admin voit tous les contrats, triés par les plus récents
        $query = \App\Models\Contrat::with(['entreprise', 'employe.user']);

        // Recherche multi-critères
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_contrat', 'like', "%{$search}%")
                  ->orWhereHas('entreprise', fn($qe) => $qe->where('raison_sociale', 'like', "%{$search}%"))
                  ->orWhereHas('employe.user', function($qu) use ($search) {
                      $qu->where('nom', 'like', "%{$search}%")
                        ->orWhere('prenom', 'like', "%{$search}%");
                  });
            });
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type_contrat', $request->type);
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $contrats = $query->latest()->paginate(15)->withQueryString();
        return view('admin.contracts.index', compact('contrats'));
    }

    // --- Statistiques et Reporting ---

    public function statistics()
    {
        // Répartition des utilisateurs par rôle (méthode sécurisée évitant RoleDoesNotExist)
        $roles = ['admin', 'employeur', 'employe', 'candidat', 'prestataire'];
        $usersByRole = [];
        foreach ($roles as $role) {
            $usersByRole[$role] = \App\Models\User::whereHas('roles', function($q) use ($role) {
                $q->where('name', $role);
            })->count();
        }

        // Statut des contrats
        $contractsByStatus = \App\Models\Contrat::selectRaw('statut, count(*) as count')
            ->groupBy('statut')
            ->pluck('count', 'statut')
            ->toArray();

        // Évolution de la masse salariale (Total des salaires bruts des contrats actifs)
        $masseSalariale = \App\Models\Contrat::where('statut', \App\Models\Contrat::STATUS_ACTIVE)->sum('salaire_mensuel_brut');

        return view('admin.statistics', compact('usersByRole', 'contractsByStatus', 'masseSalariale'));
    }
}

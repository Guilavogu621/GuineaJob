<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::with('user')->get();
        return view('admin.dashboard', compact('entreprises'));
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

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
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

        return redirect()->route('admin.dashboard')->with('success', 'Employeur et Entreprise créés avec succès.');
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
}

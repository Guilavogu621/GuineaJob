<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        \Log::info("REGISTER ATTEMPT:", $request->all());

        $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'string', 'in:candidat,prestataire'], // Sécurité : seuls ces 2 rôles
            'raison_sociale' => ['nullable', 'required_if:role,prestataire', 'string', 'max:150', 'unique:entreprises,raison_sociale'],
            'secteur' => ['nullable', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nom'                => $request->nom,
            'prenom'             => $request->prenom,
            'email'              => $request->email,
            'role'               => $request->role,
            'password'           => Hash::make($request->password),
            'must_change_password' => false,
            // Auto-vérification : pas de mail de confirmation nécessaire pour candidat/prestataire
            'email_verified_at'  => now(),
        ]);

        // Synchroniser le rôle Spatie si disponible
        try {
            $user->assignRole($request->role);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Spatie role assign failed: ' . $e->getMessage());
        }

        // Si prestataire, créer l'entreprise associée
        if ($request->role === 'prestataire') {
            Entreprise::create([
                'user_id' => $user->id,
                'raison_sociale' => $request->raison_sociale,
                'secteur' => $request->secteur,
                'telephone' => $request->telephone,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirection vers le bon tableau de bord selon le rôle
        return redirect(route('dashboard', absolute: false));
    }
}

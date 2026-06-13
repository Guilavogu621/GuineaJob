<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Vérification du rôle via Spatie
        if (!$user->hasRole($role)) {
            // Si l'utilisateur n'a pas le bon rôle, on le renvoie vers son propre dashboard
            if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
            if ($user->hasRole('employeur')) return redirect()->route('employer.dashboard');
            if ($user->hasRole('employe')) return redirect()->route('employee.dashboard');
            if ($user->hasRole(['candidat', 'prestataire'])) return redirect()->route('dashboard');

            return redirect('/');
        }

        return $next($request);
    }
}

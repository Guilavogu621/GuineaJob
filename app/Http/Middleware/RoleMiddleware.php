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

        // Vérification du rôle
        if ($user->role !== $role) {
            // Si l'utilisateur n'a pas le bon rôle, on le renvoie vers son propre dashboard
            if ($user->role === 'admin') return redirect()->route('admin.dashboard');
            if ($user->role === 'employeur') return redirect()->route('employer.dashboard');
            if ($user->role === 'employe') return redirect()->route('employee.dashboard');
            
            return redirect('/');
        }

        return $next($request);
    }
}

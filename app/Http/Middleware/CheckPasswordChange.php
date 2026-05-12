<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->must_change_password) {
            // Si l'utilisateur doit changer son mot de passe et n'est pas déjà sur la page de changement
            if (!$request->is('password/change')) {
                return redirect('/password/change')->with('info', 'Pour votre sécurité, vous devez changer votre mot de passe temporaire.');
            }
        }

        return $next($request);
    }
}

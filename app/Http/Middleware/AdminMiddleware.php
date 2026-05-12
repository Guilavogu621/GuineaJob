<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Si pas admin, on renvoie vers le dashboard normal avec un message d'erreur
        return redirect('/dashboard')->with('error', 'Accès réservé aux administrateurs.');
    }
}

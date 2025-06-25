<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  mixed  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $userRole = strtolower(Auth::user()->role);

        foreach ($roles as $role) {
            if ($userRole == strtolower($role)) {
                return $next($request);
            }
        }

        // Si l'utilisateur est connecté mais n'a pas le bon rôle, on le redirige avec une erreur.
        return redirect('/home')->with('error', 'Accès non autorisé.');
    }
}

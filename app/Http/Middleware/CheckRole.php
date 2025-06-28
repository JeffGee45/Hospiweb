<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Si aucun rôle n'est spécifié, on refuse l'accès
        if (empty($roles)) {
            abort(403, 'Accès non autorisé : aucun rôle spécifié.');
        }

        // Vérifier si l'utilisateur a l'un des rôles requis
        foreach ($roles as $role) {
            // Explode the string by '|' to get individual roles
            $requiredRoles = explode('|', $role);

            // Trim whitespace from each role in the list
            $trimmedRoles = array_map('trim', $requiredRoles);

            // Check if the user's role is in the list of required roles
            if (in_array($user->role, $trimmedRoles)) {
                return $next($request);
            }
        }

        // Si l'utilisateur n'a aucun des rôles requis
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }
        
        return redirect()->route('dashboard')
                         ->with('error', 'Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
    }
}

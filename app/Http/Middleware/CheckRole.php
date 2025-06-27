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
            // Gérer les rôles multiples séparés par des virgules
            $roleList = explode(',', $role);
            
            foreach ($roleList as $r) {
                $r = trim($r);
                if ($user->role === $r) {
                    return $next($request);
                }
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

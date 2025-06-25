<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Affiche la page de démarrage.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('get-started');
    }

    /**
     * Gère la complétion de l'étape de démarrage et redirige.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request)
    {
        return $this->redirectUser($request->user());
    }

    /**
     * Redirige l'utilisateur vers le tableau de bord correspondant à son rôle.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectUser($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'docteur':
                return redirect()->route('docteur.dashboard');
            case 'infirmier':
                return redirect()->route('infirmier.dashboard');
            case 'secretaire':
                return redirect()->route('secretaire.dashboard');
            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Rôle non valide ou non assigné.');
        }
    }
}

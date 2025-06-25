<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil de l'application.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Si l'utilisateur est déjà connecté, on le redirige vers le tableau de bord.
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // Sinon, on affiche la page d'accueil publique.
        return view('home');
    }
}

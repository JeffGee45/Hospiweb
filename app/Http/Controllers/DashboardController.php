<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function docteurDashboard()
    {
        return view('docteur.dashboard');
    }

    public function infirmierDashboard()
    {
        return view('infirmier.dashboard');
    }

    public function secretaireDashboard()
    {
        return view('secretaire.dashboard');
    }
}

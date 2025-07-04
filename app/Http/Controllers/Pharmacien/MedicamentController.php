<?php

namespace App\Http\Controllers\Pharmacien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicamentController extends Controller
{
    // Affiche la liste des médicaments
    public function index()
    {
        // Pour l'instant, retourne une vue simple
        return view('pharmacien.medicaments.index');
    }
}

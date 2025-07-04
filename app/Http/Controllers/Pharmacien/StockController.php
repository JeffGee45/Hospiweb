<?php

namespace App\Http\Controllers\Pharmacien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // Affiche la liste des stocks
    public function index()
    {
        // Pour l'instant, retourne une vue vide ou un message simple
        return view('pharmacien.stock.index');
    }
}

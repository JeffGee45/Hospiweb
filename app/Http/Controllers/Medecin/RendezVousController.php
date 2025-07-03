<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendezVousController extends Controller
{
    /**
     * Affiche la liste simplifiée des rendez-vous
     */
    public function index()
    {
        $rendezVous = RendezVous::with('patient')
            ->where('medecin_id', Auth::id())
            ->whereDate('date_rendez_vous', '>=', now())
            ->orderBy('date_rendez_vous')
            ->paginate(10);

        return view('medecin.rendez-vous.index', compact('rendezVous'));
  }

    /**
     * Affiche les détails d'un rendez-vous
     */
    public function show($id)
    {
        $rendezVous = RendezVous::with('patient')
            ->where('medecin_id', Auth::id())
            ->findOrFail($id);

        return view('medecin.rendez-vous.show', compact('rendezVous'));
    }

    /**
     * Annule un rendez-vous
     */
    public function annuler($id)
    {
        $rendezVous = RendezVous::where('medecin_id', Auth::id())
            ->findOrFail($id);

        $rendezVous->update(['statut' => 'Annulé']);

        return back()->with('success', 'Le rendez-vous a été annulé avec succès.');
    }
}

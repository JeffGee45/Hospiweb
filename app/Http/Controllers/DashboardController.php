<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\RendezVous;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        // Met à jour automatiquement les statuts des rendez-vous
        $now = Carbon::now();
        RendezVous::where('statut', 'Confirmé')
            ->where('date_rendez_vous', '<', $now)
            ->update(['statut' => 'Terminé']);
        // Optionnel : gérer les "Non honoré" si besoin

        // 5 prochains rendez-vous (en attente ou confirmé, aujourd'hui ou plus tard, triés)
        $rendezVousProchains = RendezVous::with(['patient', 'user'])
            ->whereIn('statut', ['En attente', 'Confirmé'])
            ->whereDate('date_rendez_vous', '>=', $now->toDateString())
            ->orderBy('date_rendez_vous', 'asc')
            ->limit(5)
            ->get();
        // 5 derniers rendez-vous terminés
        $rendezVousTermines = RendezVous::with(['patient', 'user'])
            ->where('statut', 'Terminé')
            ->orderBy('date_rendez_vous', 'desc')
            ->limit(5)
            ->get();

        // 5 derniers rendez-vous annulés
        $rendezVousAnnules = RendezVous::with(['patient', 'user'])
            ->where('statut', 'Annulé')
            ->orderBy('date_rendez_vous', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('patients', 'rendezVousProchains', 'rendezVousTermines', 'rendezVousAnnules'));
    }
}

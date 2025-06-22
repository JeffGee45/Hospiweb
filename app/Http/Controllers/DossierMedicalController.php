<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\DossierMedical;
use Illuminate\Http\Request;

class DossierMedicalController extends Controller
{
    public function show(Patient $patient)
    {
        // Récupère le dossier médical ou en crée un nouveau s'il n'existe pas.
        $dossier = $patient->dossierMedical()->firstOrCreate([]);

        return view('dossiers.show', compact('patient', 'dossier'));
    }

    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            'observation_globale' => 'nullable|string',
        ]);

        // Met à jour le dossier existant ou en crée un nouveau.
        $patient->dossierMedical()->updateOrCreate(
            ['patient_id' => $patient->id], // Condition de recherche
            ['observation_globale' => $request->observation_globale] // Données à mettre à jour ou créer
        );

        return back()->with('success', 'Dossier médical mis à jour avec succès.');
    }
}

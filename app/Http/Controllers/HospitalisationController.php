<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Hospitalisation;
use Illuminate\Http\Request;

class HospitalisationController extends Controller
{
    /**
     * Affiche la liste des hospitalisations pour un patient donné.
     */
    public function index(Patient $patient)
    {
        $hospitalisations = $patient->hospitalisations()->latest()->paginate(10);
        return view('hospitalisations.index', compact('patient', 'hospitalisations'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle hospitalisation.
     */
    public function create(Patient $patient)
    {
        return view('hospitalisations.create', compact('patient'));
    }

    /**
     * Enregistre une nouvelle hospitalisation dans la base de données.
     */
    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            'date_entree' => 'required|date',
            'date_sortie' => 'nullable|date|after_or_equal:date_entree',
            'chambre' => 'nullable|string|max:255',
            'traitement_suivi' => 'nullable|string',
        ]);

        $patient->hospitalisations()->create($request->all());

        return redirect()->route('patients.hospitalisations.index', $patient)->with('success', 'Hospitalisation ajoutée avec succès.');
    }
}

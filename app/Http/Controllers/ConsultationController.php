<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Affiche la liste des consultations pour un patient donné.
     */
    public function index(Patient $patient)
    {
        $consultations = $patient->consultations()->with('medecin')->latest()->paginate(10);
        return view('consultations.index', compact('patient', 'consultations'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle consultation.
     */
    public function create(Patient $patient)
    {
        $medecins = User::where('role', 'Médecin')->get();
        return view('consultations.create', compact('patient', 'medecins'));
    }

    /**
     * Enregistre une nouvelle consultation dans la base de données.
     */
    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            'medecin_id' => 'required|exists:users,id',
            'date_consultation' => 'required|date',
            'diagnostic' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $patient->consultations()->create($request->all());

        return redirect()->route('patients.consultations.index', $patient)->with('success', 'Consultation ajoutée avec succès.');
    }

    public function show(Consultation $consultation)
    {
        $consultation->load('patient', 'medecin', 'prescription.medicaments');
        return view('consultations.show', compact('consultation'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    /**
     * Affiche la liste des consultations pour un patient donné.
     */
    public function index(Patient $patient)
    {
        $this->authorize('viewAny', [Consultation::class, $patient]);
        
        $consultations = $patient->consultations()
            ->with('medecin')
            ->latest()
            ->paginate(10);
            
        return view('medecin.consultations.index', compact('patient', 'consultations'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle consultation.
     */
    public function create(Patient $patient)
    {
        $this->authorize('create', [Consultation::class, $patient]);
        
        // Le médecin connecté est automatiquement sélectionné
        $medecin = Auth::user();
        
        return view('medecin.consultations.create', compact('patient', 'medecin'));
    }

    /**
     * Enregistre une nouvelle consultation dans la base de données.
     */
    public function store(Request $request, Patient $patient)
    {
        $this->authorize('create', [Consultation::class, $patient]);
        
        $validated = $request->validate([
            'date_consultation' => 'required|date',
            'motif' => 'required|string|max:255',
            'diagnostic' => 'nullable|string',
            'traitement' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        // Ajouter l'ID du médecin connecté
        $validated['medecin_id'] = Auth::id();

        $consultation = $patient->consultations()->create($validated);

        return redirect()
            ->route('medecin.patients.consultations.show', [$patient, $consultation])
            ->with('success', 'Consultation ajoutée avec succès.');
    }

    /**
     * Affiche les détails d'une consultation.
     */
    public function show(Patient $patient, Consultation $consultation)
    {
        $this->authorize('view', $consultation);
        
        $consultation->load('medecin', 'prescription.medicaments');
        return view('medecin.consultations.show', compact('patient', 'consultation'));
    }
}

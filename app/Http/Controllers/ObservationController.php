<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObservationController extends Controller
{
    /**
     * Affiche la liste des observations
     */
    public function index()
    {
        $observations = Observation::with('patient', 'infirmier')
            ->where('infirmier_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('infirmier.observations.index', compact('observations'));
    }

    /**
     * Affiche le formulaire de création d'observation
     */
    public function create($patientId = null)
    {
        $patients = [];
        $selectedPatient = null;
        
        if ($patientId) {
            $selectedPatient = Patient::findOrFail($patientId);
        } else {
            $patients = Patient::orderBy('nom')->get();
        }

        return view('infirmier.observations.create', compact('patients', 'selectedPatient'));
    }

    /**
     * Enregistre une nouvelle observation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date_observation' => 'required|date',
            'heure_observation' => 'required|date_format:H:i',
            'type_observation' => 'required|string|max:255',
            'valeur' => 'required|string|max:255',
            'unite' => 'nullable|string|max:50',
            'commentaire' => 'nullable|string',
            'est_urgent' => 'boolean',
        ]);

        $observation = new Observation($validated);
        $observation->infirmier_id = Auth::id();
        $observation->save();

        return redirect()
            ->route('infirmier.observations.show', $observation)
            ->with('success', 'Observation enregistrée avec succès.');
    }

    /**
     * Affiche les détails d'une observation
     */
    public function show(Observation $observation)
    {
        $this->authorize('view', $observation);
        return view('infirmier.observations.show', compact('observation'));
    }

    /**
     * Affiche le formulaire de modification d'une observation
     */
    public function edit(Observation $observation)
    {
        $this->authorize('update', $observation);
        $patients = Patient::orderBy('nom')->get();
        return view('infirmier.observations.edit', compact('observation', 'patients'));
    }

    /**
     * Met à jour une observation existante
     */
    public function update(Request $request, Observation $observation)
    {
        $this->authorize('update', $observation);

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date_observation' => 'required|date',
            'heure_observation' => 'required|date_format:H:i',
            'type_observation' => 'required|string|max:255',
            'valeur' => 'required|string|max:255',
            'unite' => 'nullable|string|max:50',
            'commentaire' => 'nullable|string',
            'est_urgent' => 'boolean',
        ]);

        $observation->update($validated);

        return redirect()
            ->route('infirmier.observations.show', $observation)
            ->with('success', 'Observation mise à jour avec succès.');
    }

    /**
     * Supprime une observation
     */
    public function destroy(Observation $observation)
    {
        $this->authorize('delete', $observation);
        $observation->delete();

        return redirect()
            ->route('infirmier.observations.index')
            ->with('success', 'Observation supprimée avec succès.');
    }
}

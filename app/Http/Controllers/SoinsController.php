<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Hospitalisation;
use App\Models\Soin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoinsController extends Controller
{
    /**
     * Affiche la liste des patients hospitalisés pour les soins.
     */
    public function index()
    {
        $patients = Patient::whereHas('hospitalisations', function($query) {
            $query->where('statut', 'actif');
        })->with(['hospitalisations' => function($query) {
            $query->where('statut', 'actif');
        }])->get();

        return view('soins.index', compact('patients'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau soin.
     */
    public function create($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        return view('soins.create', compact('patient'));
    }

    /**
     * Enregistre un nouveau soin.
     */
    public function store(Request $request, $patientId)
    {
        $validated = $request->validate([
            'type_soin' => 'required|string|max:255',
            'description' => 'required|string',
            'date_soin' => 'required|date',
            'signes_vitaux' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $hospitalisation = Hospitalisation::where('patient_id', $patientId)
            ->where('statut', 'actif')
            ->firstOrFail();

        $soin = new Soin($validated);
        $soin->user_id = Auth::id();
        $soin->hospitalisation_id = $hospitalisation->id;
        $soin->save();

        return redirect()->route('soins.show', $soin->id)
            ->with('success', 'Le soin a été enregistré avec succès.');
    }

    /**
     * Affiche les détails d'un soin.
     */
    public function show($id)
    {
        $soin = Soin::with(['user', 'hospitalisation.patient'])->findOrFail($id);
        return view('soins.show', compact('soin'));
    }

    /**
     * Affiche le formulaire de modification d'un soin.
     */
    public function edit($id)
    {
        $soin = Soin::findOrFail($id);
        // Vérifier que l'utilisateur est l'auteur du soin ou a les droits nécessaires
        $this->authorize('update', $soin);
        
        return view('soins.edit', compact('soin'));
    }

    /**
     * Met à jour un soin existant.
     */
    public function update(Request $request, $id)
    {
        $soin = Soin::findOrFail($id);
        $this->authorize('update', $soin);

        $validated = $request->validate([
            'type_soin' => 'required|string|max:255',
            'description' => 'required|string',
            'date_soin' => 'required|date',
            'signes_vitaux' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $soin->update($validated);

        return redirect()->route('soins.show', $soin->id)
            ->with('success', 'Le soin a été mis à jour avec succès.');
    }

    /**
     * Affiche l'historique des soins d'un patient.
     */
    public function historique($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $soins = Soin::whereHas('hospitalisation', function($query) use ($patientId) {
            $query->where('patient_id', $patientId);
        })->with('user')->latest()->paginate(10);

        return view('soins.historique', compact('patient', 'soins'));
    }
}

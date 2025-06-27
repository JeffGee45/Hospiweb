<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Patient::query();
        if ($search = request('q')) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });
        }
        $patients = $query->with('latestConsultation')->latest()->paginate(10)->appends(['q' => $search]);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'sexe' => 'required|string|in:Homme,Femme,Autre',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:patients,email',
            'groupe_sanguin' => 'nullable|string|max:5',
            'antecedents_medicaux' => 'nullable|string',
            'allergies' => 'nullable|string',
            'nom_contact_urgence' => 'nullable|string|max:255',
            'telephone_contact_urgence' => 'nullable|string|max:20',
        ]);

        $validatedData['statut'] = 'Actif';

        Patient::create($validatedData);

        return redirect()->route('patients.index')
                         ->with('success', 'Patient créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'sexe' => 'required|string|in:Homme,Femme,Autre',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:patients,email,' . $patient->id,
            'groupe_sanguin' => 'nullable|string|max:5',
            'antecedents_medicaux' => 'nullable|string',
            'allergies' => 'nullable|string',
            'nom_contact_urgence' => 'nullable|string|max:255',
            'telephone_contact_urgence' => 'nullable|string|max:20',
            'statut' => 'string',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')
                         ->with('success', 'Patient mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
                         ->with('success', 'Patient supprimé avec succès.');
    }

    /**
     * Change le statut du patient (Actif, Inactif, Décédé).
     */
    public function changeStatus(Request $request, Patient $patient)
    {
        $request->validate([
            'statut' => 'required|string|in:Actif,Inactif,Décédé',
        ]);

        $patient->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut du patient mis à jour avec succès.');
    }
}

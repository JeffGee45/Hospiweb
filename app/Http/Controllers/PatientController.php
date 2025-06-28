<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


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

        $rolePrefix = strtolower(Auth::user()->role);
        return redirect()->route("{$rolePrefix}.patients.index")
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
        try {
            $validatedData = $request->validate([
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
                'statut' => 'sometimes|string|in:Actif,Inactif,Décédé',
            ]);

            // Journalisation avant la mise à jour
            Log::info('Mise à jour du patient', [
                'patient_id' => $patient->id,
                'anciennes_donnees' => $patient->toArray(),
                'nouvelles_donnees' => $validatedData,
                'effectue_par' => Auth::check() ? Auth::user()->name : 'Système',
            ]);

            $patient->update($validatedData);

            $rolePrefix = strtolower(Auth::user()->role);
            return redirect()->route("{$rolePrefix}.patients.index")
                             ->with('success', 'Patient mis à jour avec succès.');
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du patient', [
                'patient_id' => $patient->id,
                'erreur' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                    ->withInput()
                    ->with('error', 'Une erreur est survenue lors de la mise à jour du patient. Veuillez réessayer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        try {
            // Journalisation avant suppression
            Log::info('Suppression du patient', [
                'patient_id' => $patient->id,
                'nom_complet' => $patient->prenom . ' ' . $patient->nom,
                'effectue_par' => Auth::check() ? Auth::user()->name : 'Système',
            ]);

            // Suppression du patient (les relations sont gérées par le modèle avec onDelete('cascade'))
            $patient->delete();

            return redirect()->route('admin.patients.index')
                             ->with('success', 'Le patient a été supprimé avec succès.');
                             
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du patient', [
                'patient_id' => $patient->id,
                'erreur' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Une erreur est survenue lors de la suppression du patient. Veuillez réessayer.');
        }
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

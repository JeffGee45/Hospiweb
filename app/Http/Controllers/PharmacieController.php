<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PharmacieController extends Controller
{
    /**
     * Affiche la liste des prescriptions à valider.
     */
    public function index()
    {
        $prescriptions = Prescription::where('statut', 'en_attente')->with('patient', 'medecin')->latest()->paginate(10);
        return view('pharmacie.index', compact('prescriptions'));
    }

    /**
     * Valide une prescription.
     */
    public function valider(Request $request, Prescription $prescription)
    {
        $prescription->update(['statut' => 'validee']);
        return redirect()->route('pharmacien.pharmacie.index')->with('success', 'La prescription a été validée.');
    }

    /**
     * Affiche l'historique des prescriptions.
     */
    public function historique()
    {
        $prescriptions = Prescription::whereIn('statut', ['validee', 'delivree'])
            ->with('patient', 'medecin')
            ->latest()
            ->paginate(10);
        return view('pharmacie.historique', compact('prescriptions'));
    }
}

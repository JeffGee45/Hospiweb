<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function create(Consultation $consultation)
    {
        return view('prescriptions.create', compact('consultation'));
    }

    public function store(Request $request, Consultation $consultation)
    {
        $request->validate([
            'date_prescription' => 'required|date',
            'medicaments' => 'required|array|min:1',
            'medicaments.*.nom_medicament' => 'required|string|max:255',
            'medicaments.*.dosage' => 'required|string|max:255',
            'medicaments.*.duree' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $consultation) {
            $prescription = $consultation->prescription()->create([
                'consultation_id' => $consultation->id,
                'medecin_id' => $consultation->medecin_id,
                'date_prescription' => $request->date_prescription,
            ]);

            foreach ($request->medicaments as $medicamentData) {
                $prescription->medicaments()->create($medicamentData);
            }
        });

        return redirect()->route('consultations.show', $consultation->id)->with('success', 'Prescription ajoutée avec succès.');
    }
}

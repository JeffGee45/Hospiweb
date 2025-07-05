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
        $validated = $request->validate([
            'date_prescription' => 'required|date',
            'validite' => 'required|integer|min:1|max:12',
            'medicaments' => 'required|array|min:1',
            'medicaments.*.nom_medicament' => 'required|string|max:255',
            'medicaments.*.dosage' => 'required|string|max:255',
            'medicaments.*.duree' => 'required|string|max:255',
            'medicaments.*.frequence' => 'required|string|max:50',
            'medicaments.*.quantite' => 'required|integer|min:1',
            'medicaments.*.instructions' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($validated, $consultation) {
            // Créer la prescription
            $prescription = $consultation->prescription()->create([
                'consultation_id' => $consultation->id,
                'medecin_id' => $consultation->medecin_id,
                'date_prescription' => $validated['date_prescription'],
                'date_expiration' => now()->addMonths($validated['validite']),
                'statut' => 'en_attente',
            ]);

            // Ajouter les médicaments à la prescription
            foreach ($validated['medicaments'] as $medicamentData) {
                // Rechercher le médicament par nom pour obtenir son ID
                $medicament = \App\Models\Medicament::where('nom', 'like', '%' . $medicamentData['nom_medicament'] . '%')->first();
                
                $prescription->medicaments()->create([
                    'medicament_id' => $medicament ? $medicament->id : null,
                    'nom_medicament' => $medicamentData['nom_medicament'],
                    'dosage' => $medicamentData['dosage'],
                    'duree' => $medicamentData['duree'],
                    'frequence' => $medicamentData['frequence'],
                    'quantite' => $medicamentData['quantite'],
                    'instructions' => $medicamentData['instructions'] ?? null,
                    'posologie_details' => "{$medicamentData['dosage']}, {$medicamentData['frequence']} pendant {$medicamentData['duree']}",
                    'duree_jours' => (int) preg_replace('/[^0-9]/', '', $medicamentData['duree']),
                ]);
            }
        });

        return redirect()
            ->route('consultations.show', $consultation->id)
            ->with('success', 'La prescription a été enregistrée avec succès.');
    }
    
    /**
     * Afficher les détails d'une prescription
     */
    public function show(Consultation $consultation, \App\Models\Prescription $prescription)
    {
        // Vérifier que la prescription appartient bien à la consultation
        if ($prescription->consultation_id !== $consultation->id) {
            abort(404);
        }
        
        // Charger les relations nécessaires
        $prescription->load(['medicaments', 'medecin', 'consultation.patient']);
        
        return view('prescriptions.show', [
            'prescription' => $prescription,
            'consultation' => $consultation,
        ]);
    }
    
    /**
     * Générer le PDF d'une prescription
     */
    public function print(Consultation $consultation, \App\Models\Prescription $prescription)
    {
        // Vérifier que la prescription appartient bien à la consultation
        if ($prescription->consultation_id !== $consultation->id) {
            abort(404);
        }
        
        // Charger les relations nécessaires
        $prescription->load(['medicaments', 'medecin', 'consultation.patient']);
        
        $data = [
            'prescription' => $prescription,
            'consultation' => $consultation,
            'title' => 'Prescription médicale',
        ];
        
        $pdf = \PDF::loadView('prescriptions.pdf', $data);
        
        // Télécharger le PDF avec un nom de fichier personnalisé
        $filename = 'prescription-' . $prescription->id . '-' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}

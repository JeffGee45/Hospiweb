<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdonnanceController extends Controller
{
    /**
     * Affiche la liste des ordonnances du médecin connecté
     */
    public function index()
    {
        $ordonnances = Ordonnance::with(['consultation.patient', 'medicaments'])
            ->where('medecin_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('medecin.ordonnances.index', compact('ordonnances'));
    }

    /**
     * Affiche le formulaire de création d'une ordonnance
     */
    public function create(Consultation $consultation = null)
    {
        $patients = [];
        $consultations = [];
        
        if ($consultation) {
            $selectedPatient = $consultation->patient;
            $consultations = Consultation::where('patient_id', $selectedPatient->id)
                ->where('medecin_id', Auth::id())
                ->latest()
                ->get();
        } else {
            $patients = Patient::whereHas('consultations', function($query) {
                $query->where('medecin_id', Auth::id());
            })->get();
        }

        return view('medecin.ordonnances.create', compact('patients', 'consultation', 'consultations'));
    }

    /**
     * Enregistre une nouvelle ordonnance
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'date_ordonnance' => 'required|date',
            'medicaments' => 'required|array|min:1',
            'medicaments.*.nom' => 'required|string|max:255',
            'medicaments.*.posologie' => 'required|string|max:255',
            'medicaments.*.duree' => 'required|string|max:100',
            'commentaire' => 'nullable|string',
        ]);

        // Création de l'ordonnance
        $ordonnance = new Ordonnance();
        $ordonnance->consultation_id = $validated['consultation_id'];
        $ordonnance->medecin_id = Auth::id();
        $ordonnance->date_ordonnance = $validated['date_ordonnance'];
        $ordonnance->commentaire = $validated['commentaire'] ?? null;
        $ordonnance->save();

        // Ajout des médicaments
        foreach ($validated['medicaments'] as $medicament) {
            $ordonnance->medicaments()->create([
                'nom' => $medicament['nom'],
                'posologie' => $medicament['posologie'],
                'duree' => $medicament['duree'],
            ]);
        }

        return redirect()
            ->route('medecin.ordonnances.show', $ordonnance)
            ->with('success', 'Ordonnance créée avec succès.');
    }

    /**
     * Affiche les détails d'une ordonnance
     */
    public function show(Ordonnance $ordonnance)
    {
        $this->authorize('view', $ordonnance);
        $ordonnance->load(['consultation.patient', 'medicaments']);
        
        return view('medecin.ordonnances.show', compact('ordonnance'));
    }

    /**
     * Affiche le formulaire de modification d'une ordonnance
     */
    public function edit(Ordonnance $ordonnance)
    {
        $this->authorize('update', $ordonnance);
        $ordonnance->load(['consultation.patient', 'medicaments']);
        
        return view('medecin.ordonnances.edit', compact('ordonnance'));
    }

    /**
     * Met à jour une ordonnance existante
     */
    public function update(Request $request, Ordonnance $ordonnance)
    {
        $this->authorize('update', $ordonnance);

        $validated = $request->validate([
            'date_ordonnance' => 'required|date',
            'medicaments' => 'required|array|min:1',
            'medicaments.*.id' => 'nullable|exists:medicament_ordonnance,id',
            'medicaments.*.nom' => 'required|string|max:255',
            'medicaments.*.posologie' => 'required|string|max:255',
            'medicaments.*.duree' => 'required|string|max:100',
            'commentaire' => 'nullable|string',
        ]);

        // Mise à jour de l'ordonnance
        $ordonnance->date_ordonnance = $validated['date_ordonnance'];
        $ordonnance->commentaire = $validated['commentaire'] ?? null;
        $ordonnance->save();

        // Mise à jour des médicaments
        $medicamentIds = [];
        foreach ($validated['medicaments'] as $medicamentData) {
            if (isset($medicamentData['id'])) {
                // Mise à jour d'un médicament existant
                $medicament = $ordonnance->medicaments()->find($medicamentData['id']);
                if ($medicament) {
                    $medicament->update([
                        'nom' => $medicamentData['nom'],
                        'posologie' => $medicamentData['posologie'],
                        'duree' => $medicamentData['duree'],
                    ]);
                    $medicamentIds[] = $medicament->id;
                }
            } else {
                // Création d'un nouveau médicament
                $newMedicament = $ordonnance->medicaments()->create([
                    'nom' => $medicamentData['nom'],
                    'posologie' => $medicamentData['posologie'],
                    'duree' => $medicamentData['duree'],
                ]);
                $medicamentIds[] = $newMedicament->id;
            }
        }

        // Suppression des médicaments qui ne sont plus dans la liste
        $ordonnance->medicaments()->whereNotIn('id', $medicamentIds)->delete();

        return redirect()
            ->route('medecin.ordonnances.show', $ordonnance)
            ->with('success', 'Ordonnance mise à jour avec succès.');
    }

    /**
     * Supprime une ordonnance
     */
    public function destroy(Ordonnance $ordonnance)
    {
        $this->authorize('delete', $ordonnance);
        
        $ordonnance->medicaments()->delete();
        $ordonnance->delete();

        return redirect()
            ->route('medecin.ordonnances.index')
            ->with('success', 'Ordonnance supprimée avec succès.');
    }

    /**
     * Génère un PDF de l'ordonnance
     */
    public function generatePdf(Ordonnance $ordonnance)
    {
        $this->authorize('view', $ordonnance);
        $ordonnance->load(['consultation.patient', 'medicaments']);
        
        $pdf = PDF::loadView('pdf.ordonnance', compact('ordonnance'));
        return $pdf->download("ordonnance-{$ordonnance->id}.pdf");
    }

    // Les fonctionnalités d'email seront ajoutées ultérieurement
}

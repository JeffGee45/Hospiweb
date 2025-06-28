<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\Medecin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RendezVousController extends Controller
{
    /**
     * Affiche la liste des rendez-vous du patient connecté
     */
    public function index()
    {
        $patient = Auth::user()->patient;
        $rendezVous = $patient->rendezVous()
            ->with('medecin.user')
            ->orderBy('date_rendez_vous', 'desc')
            ->paginate(10);

        return view('patient.rendez-vous.index', compact('rendezVous'));
    }

    /**
     * Affiche le formulaire de prise de rendez-vous
     */
    public function create()
    {
        $medecins = Medecin::with('user')
            ->whereHas('user', function($query) {
                $query->where('statut', 'actif');
            })
            ->get();

        return view('patient.rendez-vous.create', compact('medecins'));
    }

    /**
     * Enregistre un nouveau rendez-vous
     */
    public function store(Request $request)
    {
        $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date_rendez_vous' => 'required|date|after:now',
            'motif' => 'required|string|max:500',
        ]);

        // Vérifier la disponibilité du médecin
        $existingRdv = RendezVous::where('medecin_id', $request->medecin_id)
            ->where('date_rendez_vous', '<=', Carbon::parse($request->date_rendez_vous)->addHour())
            ->where('date_rendez_vous', '>=', Carbon::parse($request->date_rendez_vous)->subHour())
            ->where('statut', '!=', 'annule')
            ->exists();

        if ($existingRdv) {
            return back()->withErrors(['date_rendez_vous' => 'Le médecin a déjà un rendez-vous à cette heure.'])->withInput();
        }

        // Créer le rendez-vous
        $rendezVous = new RendezVous([
            'patient_id' => Auth::user()->patient->id,
            'medecin_id' => $request->medecin_id,
            'date_rendez_vous' => $request->date_rendez_vous,
            'type_rendez_vous' => $request->type_rendez_vous ?? 'consultation',
            'statut' => 'en_attente',
            'motif' => $request->motif,
            'source_demande' => 'en_ligne',
        ]);

        $rendezVous->save();

        // Ici, vous pourriez ajouter l'envoi d'email de confirmation

        return redirect()->route('patient.rendez-vous.index')
            ->with('success', 'Votre demande de rendez-vous a été enregistrée avec succès.');
    }

    /**
     * Affiche les détails d'un rendez-vous
     */
    public function show(string $id)
    {
        $rendezVous = RendezVous::with(['medecin.user', 'patient.user'])
            ->where('id', $id)
            ->where('patient_id', Auth::user()->patient->id)
            ->firstOrFail();

        return view('patient.rendez-vous.show', compact('rendezVous'));
    }

    /**
     * Annule un rendez-vous
     */
    public function annuler(string $id)
    {
        $rendezVous = RendezVous::where('id', $id)
            ->where('patient_id', Auth::user()->patient->id)
            ->whereIn('statut', ['en_attente', 'confirme'])
            ->firstOrFail();

        // On ne peut annuler que les rendez-vous à venir
        if ($rendezVous->date_rendez_vous < now()) {
            return back()->with('error', 'Impossible d\'annuler un rendez-vous passé.');
        }

        $rendezVous->update(['statut' => 'annule']);

        // Ici, vous pourriez ajouter l'envoi d'email de confirmation d'annulation

        return redirect()->route('patient.rendez-vous.index')
            ->with('success', 'Le rendez-vous a été annulé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendezVousController extends Controller
{
    /**
     * Redirige vers la route appropriée en fonction du rôle de l'utilisateur
     */
    protected function redirectToRoleRoute($routeName)
    {
        $user = Auth::user();
        $role = strtolower($user->role);
        // Gérer le cas particulier pour Secrétaire
        if ($role === 'secretaire') {
            $prefix = 'secretaire.';
        } else if ($role === 'medecin') {
            $prefix = 'medecin.';
        } else if ($role === 'admin') {
            $prefix = 'admin.';
        } else {
            $prefix = '';
        }
        return redirect()->route($prefix . $routeName);
    }

    public function index()
    {
        $rendezVous = RendezVous::with(['patient', 'user'])->latest()->paginate(15);
        return view('rendez-vous.index', compact('rendezVous'));
    }

    public function create()
    {
        $patients = Patient::orderBy('nom')->get();
        $user = Auth::user();
        
        // Si l'utilisateur est un médecin, ne montrer que ses propres rendez-vous
        if ($user->role === 'Medecin') {
            $users = User::where('id', $user->id)->get();
        } else {
            $users = User::orderBy('name')->get();
        }
        
        return view('rendez-vous.create', compact('patients', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'date_rendez_vous' => 'required|date',
            'statut' => 'required|string|max:255',
            'motif' => 'nullable|string',
        ]);

        RendezVous::create($request->all());

        return $this->redirectToRoleRoute('rendez-vous.index')->with('success', 'Rendez-vous créé avec succès.');
    }

    public function edit(RendezVous $rendezVou)
    {
        $patients = Patient::orderBy('nom')->get();
        $users = User::orderBy('name')->get();
        return view('rendez-vous.edit', compact('rendezVou', 'patients', 'users'));
    }

    public function update(Request $request, RendezVous $rendezVou)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'date_rendez_vous' => 'required|date',
            'statut' => 'required|string|max:255',
            'motif' => 'nullable|string',
        ]);

        $rendezVou->update($request->all());

        return $this->redirectToRoleRoute('rendez-vous.index')->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    public function destroy(RendezVous $rendezVou)
    {
        $rendezVou->delete();
        return $this->redirectToRoleRoute('rendez-vous.index')->with('success', 'Rendez-vous supprimé avec succès.');
    }

    /**
     * Annule un rendez-vous (statut = 'Annulé').
     */
    public function annuler($id)
    {
        $rdv = RendezVous::findOrFail($id);
        if ($rdv->statut !== 'Annulé') {
            $rdv->statut = 'Annulé';
            $rdv->save();
            return $this->redirectToRoleRoute('rendez-vous.index')->with('success', 'Le rendez-vous a été annulé.');
        }
        return $this->redirectToRoleRoute('rendez-vous.index')->with('error', 'Impossible d\'annuler ce rendez-vous.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MedecinController extends Controller
{
    public function index()
    {
        $medecins = User::where('role', 'Médecin')->latest()->paginate(10);
        return view('medecins.index', compact('medecins'));
    }

    public function create()
    {
        return view('medecins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Médecin',
            'telephone' => $request->telephone,
            'specialite' => $request->specialite,
        ]);

        return redirect()->route('medecins.index')->with('success', 'Médecin ajouté avec succès.');
    }

    public function show(User $medecin)
    {
        // Vérifier que l'utilisateur est bien un médecin
        if ($medecin->role !== 'Medecin') {
            abort(404);
        }
        return view('medecins.show', compact('medecin'));
    }

    public function edit(User $medecin)
    {
        // Vérifier que l'utilisateur est bien un médecin
        if ($medecin->role !== 'Medecin') {
            abort(404);
        }
        return view('medecins.edit', compact('medecin'));
    }

    public function update(Request $request, User $medecin)
    {
        // Vérifier que l'utilisateur est bien un médecin
        if ($medecin->role !== 'Medecin') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $medecin->id,
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'required|string|max:255',
        ]);

        $medecin->update($request->all());

        return redirect()->route('medecins.index')->with('success', 'Médecin mis à jour avec succès.');
    }

    public function destroy(User $medecin)
    {
        // Vérifier que l'utilisateur est bien un médecin
        if ($medecin->role !== 'Medecin') {
            abort(404);
        }
        $medecin->delete();
        return redirect()->route('medecins.index')->with('success', 'Médecin supprimé avec succès.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    public function index()
    {
        $medecins = Medecin::latest()->paginate(10);
        return view('medecins.index', compact('medecins'));
    }

    public function create()
    {
        return view('medecins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
        ]);

        Medecin::create($request->all());

        return redirect()->route('medecins.index')->with('success', 'Médecin ajouté avec succès.');
    }

    public function show(Medecin $medecin)
    {
        return view('medecins.show', compact('medecin'));
    }

    public function edit(Medecin $medecin)
    {
        return view('medecins.edit', compact('medecin'));
    }

    public function update(Request $request, Medecin $medecin)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
        ]);

        $medecin->update($request->all());

        return redirect()->route('medecins.index')->with('success', 'Médecin mis à jour avec succès.');
    }

    public function destroy(Medecin $medecin)
    {
        $medecin->delete();
        return redirect()->route('medecins.index')->with('success', 'Médecin supprimé avec succès.');
    }
}

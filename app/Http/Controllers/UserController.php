<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Recherche par nom ou email
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filtre par rôle
        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        // Filtre par statut (actif/inactif)
        if ($status = $request->input('status')) {
            $query->where('is_active', $status === 'active');
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = ['Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier'];
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Affiche le formulaire de création d'un utilisateur.
     */
    public function create()
    {
        $roles = ['Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier'];
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Enregistre un nouvel utilisateur dans la base de données.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['Admin', 'Médecin', 'Secrétaire', 'Infirmier', 'Pharmacien', 'Caissier'])],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

                Log::info('Utilisateur créé : ' . $user->name . ' (ID: ' . $user->id . ') par ' . Auth::user()->name);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche les détails d'un utilisateur.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur.
     */
    public function edit(User $user)
    {
        $roles = ['Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Met à jour un utilisateur dans la base de données.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['Admin', 'Médecin', 'Secrétaire', 'Infirmier', 'Pharmacien', 'Caissier'])],
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

                Log::info('Utilisateur mis à jour : ' . $user->name . ' (ID: ' . $user->id . ') par ' . Auth::user()->name);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur de la base de données.
     */
    public function destroy(User $user)
    {
                Log::warning('Utilisateur supprimé : ' . $user->name . ' (ID: ' . $user->id . ') par ' . Auth::user()->name);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}

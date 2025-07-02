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
        
        // Récupérer les valeurs des filtres
        $filters = [
            'search' => $request->input('search'),
            'role' => $request->input('role'),
            'status' => $request->input('status'),
        ];
        
        // Appliquer les filtres
        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }
        
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('is_active', $filters['status']);
        }
        
        $users = $query->latest()->paginate(10)->withQueryString();
        
        // Rôles disponibles pour le filtre
        $roles = ['Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier'];
        
        return view('admin.users.index', compact('users', 'filters', 'roles'));
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

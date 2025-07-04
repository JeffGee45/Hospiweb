<?php

namespace App\Policies;

use App\Models\Ordonnance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrdonnancePolicy
{
    /**
     * Détermine si l'utilisateur peut voir n'importe quel modèle.
     * Seul un médecin peut voir ses propres ordonnances
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Médecin');
    }

    /**
     * Détermine si l'utilisateur peut voir le modèle.
     * Un médecin peut voir ses propres ordonnances
     */
    public function view(User $user, Ordonnance $ordonnance): bool
    {
        return $user->id === $ordonnance->medecin_id || 
               $user->hasRole('Admin');
    }

    /**
     * Détermine si l'utilisateur peut créer des modèles.
     * Seul un médecin peut créer des ordonnances
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Médecin');
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour le modèle.
     * Un médecin peut mettre à jour ses propres ordonnances
     */
    public function update(User $user, Ordonnance $ordonnance): bool
    {
        return $user->id === $ordonnance->medecin_id || 
               $user->hasRole('Admin');
    }

    /**
     * Détermine si l'utilisateur peut supprimer le modèle.
     * Un médecin peut supprimer ses propres ordonnances
     */
    public function delete(User $user, Ordonnance $ordonnance): bool
    {
        return $user->id === $ordonnance->medecin_id || 
               $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ordonnance $ordonnance): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ordonnance $ordonnance): bool
    {
        return false;
    }
}

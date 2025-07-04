<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultationPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir n'importe quel modèle.
     */
    public function viewAny(User $user, Patient $patient): bool
    {
        // Un médecin peut voir les consultations de ses patients
        if ($user->role === 'Médecin') {
            return $user->isMyPatient($patient->id);
        }
        
        // Par défaut, refuser l'accès
        return false;
    }

    /**
     * Détermine si l'utilisateur peut voir le modèle.
     */
    public function view(User $user, Consultation $consultation): bool
    {
        // Un médecin ne peut voir que les consultations de ses patients
        if ($user->role === 'Médecin') {
            return $user->isMyPatient($consultation->patient_id);
        }
        
        // Par défaut, refuser l'accès
        return false;
    }

    /**
     * Détermine si l'utilisateur peut créer des modèles.
     */
    public function create(User $user, Patient $patient): bool
    {
        // Un médecin peut créer des consultations pour ses patients
        if ($user->role === 'Médecin') {
            return $user->isMyPatient($patient->id);
        }
        
        // Par défaut, refuser la création
        return false;
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour le modèle.
     */
    public function update(User $user, Consultation $consultation): bool
    {
        // Un médecin ne peut mettre à jour que ses propres consultations
        if ($user->role === 'Médecin') {
            return $user->id === $consultation->medecin_id && 
                   $user->isMyPatient($consultation->patient_id);
        }
        
        // Par défaut, refuser la mise à jour
        return false;
    }

    /**
     * Détermine si l'utilisateur peut supprimer le modèle.
     */
    public function delete(User $user, Consultation $consultation): bool
    {
        // Un médecin ne peut supprimer que ses propres consultations
        if ($user->role === 'Médecin') {
            return $user->id === $consultation->medecin_id && 
                   $user->isMyPatient($consultation->patient_id);
        }
        
        // Par défaut, refuser la suppression
        return false;
    }

    /**
     * Détermine si l'utilisateur peut restaurer le modèle.
     */
    public function restore(User $user, Consultation $consultation): bool
    {
        // Par défaut, refuser la restauration
        return false;
    }

    /**
     * Détermine si l'utilisateur peut supprimer définitivement le modèle.
     */
    public function forceDelete(User $user, Consultation $consultation): bool
    {
        // Par défaut, refuser la suppression définitive
        return false;
    }
}

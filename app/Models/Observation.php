<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Observation extends Model
{
    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'infirmier_id',
        'date_observation',
        'heure_observation',
        'type_observation',
        'valeur',
        'unite',
        'commentaire',
        'est_urgent',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_observation' => 'date',
        'heure_observation' => 'datetime:H:i',
        'est_urgent' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec le modèle Patient
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relation avec le modèle User (infirmier)
     */
    public function infirmier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'infirmier_id');
    }

    /**
     * Formate la date et l'heure d'observation pour l'affichage
     */
    public function getDateHeureFormateeAttribute(): string
    {
        return $this->date_observation->format('d/m/Y') . ' à ' . $this->heure_observation;
    }

    /**
     * Vérifie si l'utilisateur peut voir cette observation
     */
    public function peutEtreVuePar(User $user): bool
    {
        return $user->role === 'Admin' || 
               $this->infirmier_id === $user->id ||
               $this->patient->medecin_traitant_id === $user->id;
    }

    /**
     * Vérifie si l'utilisateur peut modifier cette observation
     */
    public function peutEtreModifieePar(User $user): bool
    {
        return $user->role === 'Admin' || $this->infirmier_id === $user->id;
    }

    /**
     * Vérifie si l'observation est urgente
     */
    public function estUrgente(): bool
    {
        return $this->est_urgent;
    }
}

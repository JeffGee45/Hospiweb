<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assureur extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'nom',
        'adresse',
        'telephone',
        'email',
        'contact_principal_nom',
        'contact_principal_telephone',
        'contact_principal_email',
        'taux_couverture',
        'plafond_remboursement',
        'notes',
        'est_actif',
    ];

    protected $casts = [
        'taux_couverture' => 'decimal:2',
        'plafond_remboursement' => 'decimal:2',
        'est_actif' => 'boolean',
    ];

    // Relations
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function hospitalisations()
    {
        return $this->hasMany(Hospitalisation::class);
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('est_actif', true);
    }

    // Méthodes utilitaires
    public function getNomCompletAttribute()
    {
        return $this->code ? "{$this->code} - {$this->nom}" : $this->nom;
    }
}

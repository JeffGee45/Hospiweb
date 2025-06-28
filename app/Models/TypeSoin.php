<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeSoin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'nom',
        'description',
        'categorie',
        'duree_moyenne', // en minutes
        'prix',
        'materiel_necessaire', // JSON
        'competences_requises', // JSON
        'est_actif',
    ];

    protected $casts = [
        'duree_moyenne' => 'integer',
        'prix' => 'decimal:2',
        'materiel_necessaire' => 'array',
        'competences_requises' => 'array',
        'est_actif' => 'boolean',
    ];

    // Relations
    public function soins()
    {
        return $this->hasMany(SoinInfirmier::class);
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

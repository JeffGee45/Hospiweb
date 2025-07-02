<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeExamen extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'nom',
        'description',
        'categorie', // biologie, imagerie, fonctionnel, etc.
        'est_actif',
        'prix',
        'duree_moyenne', // en minutes
        'preparation_requise',
        'instructions_preparation',
        'est_urgent',
        'unite_mesure',
        'valeurs_normales',
        'interpretation',
        'laboratoire_externe',
        'code_labo_externe',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'est_urgent' => 'boolean',
        'prix' => 'decimal:2',
        'duree_moyenne' => 'integer',
        'valeurs_normales' => 'array',
    ];

    // Relations
    public function examens()
    {
        return $this->hasMany(ExamenMedical::class, 'type_examen_id');
    }

    public function parametres()
    {
        return $this->hasMany(ParametreExamen::class, 'type_examen_id');
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('est_actif', true);
    }

    public function scopeParCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    public function scopeUrgents($query)
    {
        return $query->where('est_urgent', true);
    }

    // Méthodes utilitaires
    public function getNomCompletAttribute()
    {
        return "{$this->code} - {$this->nom}";
    }
}

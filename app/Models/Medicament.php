<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicament extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'nom',
        'dci',
        'forme_pharmaceutique',
        'dosage',
        'presentation',
        'prix_unitaire',
        'categorie_therapeutique',
        'classe_therapeutique',
        'laboratoire',
        'pays',
        'conditionnement_vente',
        'statut', // actif, en_rupture, supprimé
        'stock_alerte',
        'stock_physique',
        'date_peremption',
        'remboursement',
        'taux_remboursement',
        'condition_conservation',
        'contre_indications',
        'effets_secondaires',
        'interactions_medicamenteuses',
        'voie_administration',
    ];

    protected $dates = [
        'date_peremption',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'taux_remboursement' => 'decimal:2',
        'stock_alerte' => 'integer',
        'stock_physique' => 'integer',
        'remboursement' => 'boolean',
    ];

    // Relations
    public function ordonnances()
    {
        return $this->belongsToMany(Ordonnance::class, 'ordonnance_medicament')
            ->withPivot('posologie', 'duree', 'quantite', 'instructions')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeEnAlerteStock($query)
    {
        return $query->whereColumn('stock_physique', '<=', 'stock_alerte')
                    ->where('statut', 'actif');
    }

    public function scopePerimes($query)
    {
        return $query->where('date_peremption', '<', now())
                    ->where('statut', 'actif');
    }

    // Méthodes utilitaires
    public function getEstEnRuptureAttribute()
    {
        return $this->stock_physique <= $this->stock_alerte;
    }

    public function getEstPerimeAttribute()
    {
        return $this->date_peremption && $this->date_peremption->isPast();
    }

    public function getStockDisponibleAttribute()
    {
        return $this->stock_physique - $this->stock_reserve;
    }
}

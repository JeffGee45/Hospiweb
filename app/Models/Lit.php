<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'chambre_id',
        'numero',
        'code',
        'type_lit', // médicalisé, simple, soins intensifs, etc.
        'est_occupe',
        'est_en_nettoyage',
        'est_hors_service',
        'dernier_nettoyage',
        'prochain_nettoyage',
        'notes',
    ];

    protected $dates = [
        'dernier_nettoyage',
        'prochain_nettoyage',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'est_occupe' => 'boolean',
        'est_en_nettoyage' => 'boolean',
        'est_hors_service' => 'boolean',
    ];

    // Relations
    public function chambre()
    {
        return $this->belongsTo(Chambre::class);
    }

    public function hospitalisations()
    {
        return $this->hasMany(Hospitalisation::class, 'lit_id');
    }

    public function affectations()
    {
        return $this->hasMany(AffectationLit::class);
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('est_occupe', false)
                    ->where('est_hors_service', false)
                    ->where('est_en_nettoyage', false);
    }

    public function scopeOccupe($query)
    {
        return $query->where('est_occupe', true);
    }

    public function scopeHorsService($query)
    {
        return $query->where('est_hors_service', true);
    }

    public function scopeANettoyer($query)
    {
        return $query->where('est_en_nettoyage', true);
    }

    // Méthodes utilitaires
    public function getNomCompletAttribute()
    {
        $chambre = $this->chambre;
        return "Lit {$this->code} - Chambre {$chambre->numero} - Étage {$chambre->etage}";
    }

    public function getStatutCouleurAttribute()
    {
        if ($this->est_hors_service) {
            return 'bg-red-100 text-red-800';
        }
        
        if ($this->est_occupe) {
            return 'bg-yellow-100 text-yellow-800';
        }
        
        if ($this->est_en_nettoyage) {
            return 'bg-blue-100 text-blue-800';
        }
        
        return 'bg-green-100 text-green-800';
    }

    public function getStatutTexteAttribute()
    {
        if ($this->est_hors_service) {
            return 'Hors service';
        }
        
        if ($this->est_occupe) {
            return 'Occupé';
        }
        
        if ($this->est_en_nettoyage) {
            return 'En nettoyage';
        }
        
        return 'Disponible';
    }

    public function marquerCommeOccupe()
    {
        $this->update([
            'est_occupe' => true,
            'est_en_nettoyage' => false,
        ]);
        
        $this->chambre->mettreAJourStatut();
    }

    public function liberer()
    {
        $this->update([
            'est_occupe' => false,
            'est_en_nettoyage' => true,
            'dernier_nettoyage' => now(),
            'prochain_nettoyage' => now()->addDay(),
        ]);
        
        $this->chambre->mettreAJourStatut();
    }

    public function mettreHorsService($raison = null)
    {
        $this->update([
            'est_hors_service' => true,
            'est_occupe' => false,
            'est_en_nettoyage' => false,
            'notes' => $raison ? "Hors service: $raison" : null,
        ]);
        
        $this->chambre->mettreAJourStatut();
    }

    public function remettreEnService()
    {
        $this->update([
            'est_hors_service' => false,
            'est_en_nettoyage' => true,
            'dernier_nettoyage' => now(),
            'prochain_nettoyage' => now()->addDay(),
        ]);
        
        $this->chambre->mettreAJourStatut();
    }
}

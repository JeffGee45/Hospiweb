<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Service;

class Chambre extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'numero',
        'etage',
        'batiment',
        'service_id',
        'type_chambre', // individuelle, double, box, etc.
        'categorie_tarifaire',
        'prix_journalier',
        'nombre_lits',
        'lits_disponibles',
        'equipements',
        'est_occupee',
        'est_en_nettoyage',
        'est_hors_service',
        'description',
    ];

    protected $casts = [
        'prix_journalier' => 'decimal:2',
        'nombre_lits' => 'integer',
        'lits_disponibles' => 'integer',
        'est_occupee' => 'boolean',
        'est_en_nettoyage' => 'boolean',
        'est_hors_service' => 'boolean',
        'equipements' => 'array',
    ];

    // Relations
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function lits()
    {
        return $this->hasMany(Lit::class);
    }

    public function hospitalisations()
    {
        return $this->hasMany(Hospitalisation::class);
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('est_occupee', false)
                    ->where('est_hors_service', false)
                    ->where('lits_disponibles', '>', 0);
    }

    public function scopeOccupees($query)
    {
        return $query->where('est_occupee', true);
    }

    public function scopeHorsService($query)
    {
        return $query->where('est_hors_service', true);
    }

    public function scopeParService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type_chambre', $type);
    }

    // Méthodes utilitaires
    public function getNomCompletAttribute()
    {
        return "Chambre {$this->numero} - Étage {$this->etage}" . ($this->batiment ? " - Bâtiment {$this->batiment}" : '');
    }

    public function getStatutCouleurAttribute()
    {
        if ($this->est_hors_service) {
            return 'bg-red-100 text-red-800';
        }
        
        if ($this->est_occupee) {
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
        
        if ($this->est_occupee) {
            return 'Occupée';
        }
        
        if ($this->est_en_nettoyage) {
            return 'En nettoyage';
        }
        
        return 'Disponible';
    }

    public function mettreAJourStatut()
    {
        $litsOccupe = $this->lits()->where('est_occupe', true)->count();
        $this->est_occupee = $litsOccupe > 0;
        $this->lits_disponibles = $this->nombre_lits - $litsOccupe;
        $this->save();
    }
}

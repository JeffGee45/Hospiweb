<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationLit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lit_id',
        'patient_id',
        'hospitalisation_id',
        'user_id', // Utilisateur qui a effectué l'affectation
        'date_debut',
        'date_fin',
        'motif_affectation',
        'motif_liberation',
        'statut', // actif, termine, annule
        'notes',
    ];

    protected $dates = [
        'date_debut',
        'date_fin',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relations
    public function lit()
    {
        return $this->belongsTo(Lit::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospitalisation()
    {
        return $this->belongsTo(Hospitalisation::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopeActives($query)
    {
        return $query->where('statut', 'actif')
                    ->whereNull('date_fin');
    }

    public function scopeTerminees($query)
    {
        return $query->where('statut', 'termine');
    }

    public function scopeParPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    public function scopeParLit($query, $litId)
    {
        return $query->where('lit_id', $litId);
    }

    public function scopeParPeriode($query, $debut, $fin = null)
    {
        $fin = $fin ?? now();
        
        return $query->where(function($q) use ($debut, $fin) {
            $q->whereBetween('date_debut', [$debut, $fin])
              ->orWhereBetween('date_fin', [$debut, $fin])
              ->orWhere(function($q) use ($debut, $fin) {
                  $q->where('date_debut', '<=', $debut)
                    ->where(function($q) use ($fin) {
                        $q->whereNull('date_fin')
                          ->orWhere('date_fin', '>=', $fin);
                    });
              });
        });
    }

    // Méthodes utilitaires
    public function getDureeAffectationAttribute()
    {
        if (!$this->date_debut) {
            return null;
        }

        $fin = $this->date_fin ?? now();
        return $this->date_debut->diffInDays($fin) . ' jours';
    }

    public function getEstActiveAttribute()
    {
        return $this->statut === 'actif' && !$this->date_fin;
    }

    public function terminer($motif = null, $dateFin = null)
    {
        $this->update([
            'statut' => 'termine',
            'date_fin' => $dateFin ?? now(),
            'motif_liberation' => $motif,
        ]);

        // Libérer le lit s'il est toujours marqué comme occupé
        if ($this->lit->est_occupe) {
            $this->lit->liberer();
        }
    }

    // Événements du modèle
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($affectation) {
            // Marquer la date de début si non spécifiée
            if (!$affectation->date_debut) {
                $affectation->date_debut = now();
            }
            
            // Marquer le statut comme actif
            $affectation->statut = 'actif';
            
            // Si c'est une nouvelle affectation pour une hospitalisation existante
            if ($affectation->hospitalisation_id) {
                // Terminer les autres affectations actives pour cette hospitalisation
                static::where('hospitalisation_id', $affectation->hospitalisation_id)
                    ->where('statut', 'actif')
                    ->whereNull('date_fin')
                    ->update([
                        'statut' => 'termine',
                        'date_fin' => now(),
                        'motif_liberation' => 'Changement de lit',
                    ]);
            }
        });

        static::created(function ($affectation) {
            // Marquer le lit comme occupé
            if ($affectation->lit && !$affectation->lit->est_occupe) {
                $affectation->lit->marquerCommeOccupe();
            }
        });
    }
}

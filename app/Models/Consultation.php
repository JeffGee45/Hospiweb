<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'date_consultation',
        'motif_consultation',
        'poids',
        'taille',
        'temperature',
        'tension_arterielle',
        'pouls',
        'frequence_respiratoire',
        'saturation_o2',
        'glycemie',
        'antecedents',
        'allergies_connues',
        'traitement_en_cours',
        'histoire_maladie',
        'examen_clinique',
        'examen_complementaire',
        'diagnostic',
        'traitement_propose',
        'conduite_a_tenir',
        'date_prochaine_consultation',
        'statut', // prévue, en_cours, terminee, annulee
        'notes',
    ];

    protected $dates = [
        'date_consultation',
        'date_prochaine_consultation',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'allergies_connues' => 'array',
        'traitement_en_cours' => 'array',
        'examen_complementaire' => 'array',
        'poids' => 'decimal:2',
        'taille' => 'decimal:2',
        'temperature' => 'decimal:1',
        'glycemie' => 'decimal:1',
        'saturation_o2' => 'integer',
    ];

    // Relations
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }

    public function ordonnance()
    {
        return $this->hasOne(Ordonnance::class);
    }

    public function examens()
    {
        return $this->hasMany(ExamenMedical::class);
    }

    public function facture()
    {
        return $this->morphOne(Facture::class, 'facturable');
    }

    // Scopes
    public function scopeAujourdhui($query)
    {
        return $query->whereDate('date_consultation', today());
    }

    public function scopeAvenir($query)
    {
        return $query->where('date_consultation', '>=', now())
                    ->where('statut', 'prévue');
    }

    public function scopePassees($query)
    {
        return $query->where('date_consultation', '<', now())
                    ->where('statut', '!=', 'annulée');
    }

    public function scopeParMedecin($query, $medecinId)
    {
        return $query->where('medecin_id', $medecinId);
    }

    // Méthodes utilitaires
    public function getImcAttribute()
    {
        if ($this->poids && $this->taille > 0) {
            return number_format($this->poids / (($this->taille / 100) * ($this->taille / 100)), 1);
        }
        return null;
    }

    public function getStatutCouleurAttribute()
    {
        return [
            'prévue' => 'bg-blue-100 text-blue-800',
            'en_cours' => 'bg-yellow-100 text-yellow-800',
            'terminée' => 'bg-green-100 text-green-800',
            'annulée' => 'bg-red-100 text-red-800',
        ][$this->statut] ?? 'bg-gray-100 text-gray-800';
    }
}

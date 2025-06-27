<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoinInfirmier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hospitalisation_id',
        'patient_id',
        'infirmier_id',
        'type_soin_id',
        'date_soin',
        'heure_soin',
        'observations',
        'resultat',
        'statut', // planifié, effectué, annulé, reporté
        'medicaments_administres', // JSON
        'materiel_utilise', // JSON
        'duree_soin', // en minutes
        'signature_infirmier',
    ];

    protected $dates = [
        'date_soin',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'medicaments_administres' => 'array',
        'materiel_utilise' => 'array',
        'duree_soin' => 'integer',
    ];

    // Relations
    public function hospitalisation()
    {
        return $this->belongsTo(Hospitalisation::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function infirmier()
    {
        return $this->belongsTo(User::class, 'infirmier_id');
    }

    public function typeSoin()
    {
        return $this->belongsTo(TypeSoin::class);
    }

    // Scopes
    public function scopeEffectues($query)
    {
        return $query->where('statut', 'effectué');
    }

    public function scopePlanifies($query)
    {
        return $query->where('statut', 'planifié');
    }

    public function scopeParPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    public function scopeParInfirmier($query, $infirmierId)
    {
        return $query->where('infirmier_id', $infirmierId);
    }

    // Méthodes utilitaires
    public function getStatutCouleurAttribute()
    {
        return [
            'planifié' => 'bg-blue-100 text-blue-800',
            'effectué' => 'bg-green-100 text-green-800',
            'annulé' => 'bg-red-100 text-red-800',
            'reporté' => 'bg-yellow-100 text-yellow-800',
        ][$this->statut] ?? 'bg-gray-100 text-gray-800';
    }
}

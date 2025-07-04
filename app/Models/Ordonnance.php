<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ordonnance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'consultation_id',
        'medecin_id',
        'date_ordonnance',
        'commentaire',
    ];

    protected $dates = [
        'date_ordonnance',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Relation avec la consultation
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    /**
     * Relation avec le médecin
     */
    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }

    /**
     * Relation avec les médicaments de l'ordonnance
     */
    public function medicaments()
    {
        return $this->hasMany(MedicamentOrdonnance::class);
    }

    /**
     * Accès au patient via la consultation
     */
    public function getPatientAttribute()
    {
        return $this->consultation->patient;
    }
}

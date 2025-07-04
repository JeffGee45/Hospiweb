<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DossierMedical; // Add this line to import the DossierMedical model

class Patient extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'date_of_birth',
        'gender',
        'status',
        'blood_group',
        'antecedents',
    ];

    protected $attributes = [
        'status' => 'Actif',
    ];

    /**
     * Get the medical record associated with the patient.
     */
    public function dossierMedical()
    {
        return $this->hasOne(DossierMedical::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function hospitalisations()
    {
        return $this->hasMany(Hospitalisation::class);
    }

    /**
     * Récupère la dernière consultation du patient.
     */
    public function latestConsultation()
    {
        return $this->hasOne(Consultation::class)->latest('date_consultation');
    }
}

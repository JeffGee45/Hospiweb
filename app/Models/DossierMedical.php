<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\ExamenMedical;
use App\Models\Prescription;
use Carbon\Carbon;

class DossierMedical extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'groupe_sanguin',
        'poids',
        'taille',
        'tension_arterielle',
        'groupe_sanguin',
        'allergies_connues',
        'antecedents_medicaux',
        'antecedents_chirurgicaux',
        'antecedents_familiaux',
        'traitements_chroniques',
        'observations',
        'observation_globale',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'allergies_connues' => 'array',
        'antecedents_medicaux' => 'array',
        'antecedents_chirurgicaux' => 'array',
        'antecedents_familiaux' => 'array',
        'traitements_chroniques' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the patient that owns the medical record.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the consultations for the medical record.
     */
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     * Get the medical exams for the medical record.
     */
    public function examensMedicaux()
    {
        return $this->hasMany(ExamenMedical::class);
    }

    /**
     * Get the prescriptions for the medical record.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    /**
     * Get the last consultation date.
     */
    public function getDerniereConsultationAttribute()
    {
        return $this->consultations()
            ->latest('date_consultation')
            ->first();
    }

    /**
     * Get the last medical exam date.
     */
    public function getDernierExamenAttribute()
    {
        return $this->examensMedicaux()
            ->latest('date_examen')
            ->first();
    }

    /**
     * Get the last prescription date.
     */
    public function getDernierePrescriptionAttribute()
    {
        return $this->prescriptions()
            ->latest('date_prescription')
            ->first();
    }

    /**
     * Calculate and return the BMI (Body Mass Index).
     */
    public function getIMCAttribute()
    {
        if (!$this->poids || !$this->taille) {
            return null;
        }

        $tailleEnMetres = $this->taille / 100; // Convertir la taille en mètres
        return round($this->poids / ($tailleEnMetres * $tailleEnMetres), 1);
    }

    /**
     * Get the BMI category.
     */
    public function getCategorieIMCAttribute()
    {
        $imc = $this->imc;
        
        if (!$imc) {
            return 'Non disponible';
        }

        if ($imc < 18.5) {
            return 'Insuffisance pondérale';
        } elseif ($imc < 25) {
            return 'Poids normal';
        } elseif ($imc < 30) {
            return 'Surpoids';
        } else {
            return 'Obésité';
        }
    }
}

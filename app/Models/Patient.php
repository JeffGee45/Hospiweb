<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\Hospitalisation;
use App\Models\RendezVous;
use App\Models\Paiement;
use App\Models\DossierMedical;
use App\Models\ExamenMedical;
use App\Models\Prescription;

class Patient extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'user_id',
        'numero_dossier',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'telephone',
        'sexe',
        'groupe_sanguin',
        'allergies',
        'antecedents_medicaux',
        'traitements_en_cours',
        'profession',
        'nom_contact_urgence',
        'telephone_contact_urgence',
        'lien_contact_urgence',
        'notes',
        'statut'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_naissance' => 'date',
        'allergies' => 'array',
        'antecedents_medicaux' => 'array',
        'traitements_en_cours' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    /**
     * Get the user that owns the patient.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // Relations
    public function consultations()
    {
        return $this->hasMany(Consultation::class)->latest();
    }

    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class)->latest();
    }

    public function hospitalisations()
    {
        return $this->hasMany(Hospitalisation::class)->latest();
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class)->latest();
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class)->latest();
    }
    
    public function dossierMedical()
    {
        return $this->hasOne(DossierMedical::class);
    }
    
    public function examensMedicaux()
    {
        return $this->hasMany(ExamenMedical::class)->latest();
    }
    
    /**
     * Get the patient's most recent consultation.
     */
    public function latestConsultation()
    {
        return $this->hasOne(Consultation::class)->latestOfMany();
    }
    
    /**
     * Get the color class for the patient's status
     *
     * @return string
     */
    public function getStatusColor()
    {
        return match (strtolower($this->statut)) {
            'actif' => 'bg-green-100 text-green-800',
            'inactif' => 'bg-yellow-100 text-yellow-800',
            'décédé' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class)->latest();
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    // Méthodes utilitaires
    public function getAgeAttribute()
    {
        return $this->date_naissance ? $this->date_naissance->age : null;
    }
    
    /**
     * Récupère les antécédents médicaux formatés
     */
    public function getAntecedentsFormattedAttribute()
    {
        if (empty($this->antecedents_medicaux)) {
            return 'Aucun antécédent médical renseigné';
        }
        
        if (is_string($this->antecedents_medicaux)) {
            return $this->antecedents_medicaux;
        }
        
        return is_array($this->antecedents_medicaux) 
            ? implode("\n- ", array_merge([''], $this->antecedents_medicaux))
            : 'Aucun antécédent médical renseigné';
    }
    
    /**
     * Récupère les allergies formatées
     */
    public function getAllergiesFormattedAttribute()
    {
        if (empty($this->allergies)) {
            return 'Aucune allergie connue';
        }
        
        if (is_string($this->allergies)) {
            return $this->allergies;
        }
        
        return is_array($this->allergies) 
            ? implode(", ", $this->allergies)
            : 'Aucune allergie connue';
    }
    
    /**
     * Récupère les traitements en cours formatés
     */
    public function getTraitementsFormattedAttribute()
    {
        if (empty($this->traitements_en_cours)) {
            return 'Aucun traitement en cours';
        }
        
        if (is_string($this->traitements_en_cours)) {
            return $this->traitements_en_cours;
        }
        
        return is_array($this->traitements_en_cours) 
            ? implode("\n- ", array_merge([''], $this->traitements_en_cours))
            : 'Aucun traitement en cours';
    }

    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            // Générer un numéro de dossier unique
            $lastPatient = static::withTrashed()->orderBy('id', 'desc')->first();
            $lastId = $lastPatient ? $lastPatient->id : 0;
            $patient->numero_dossier = 'P' . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Récupère la dernière consultation du patient.
     */
    public function derniereConsultation()
    {
        return $this->hasOne(Consultation::class)->latest('date_consultation');
    }
}

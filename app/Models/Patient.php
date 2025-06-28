<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\Hospitalisation;
use App\Models\RendezVous;
use App\Models\Paiement;

class Patient extends Model
{

    use SoftDeletes;

    protected $fillable = [
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
        return $this->hasMany(Consultation::class);
    }

    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class);
    }

    public function hospitalisations()
    {
        return $this->hasMany(Hospitalisation::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    // Méthodes utilitaires
    public function getAgeAttribute()
    {
        return $this->date_naissance->age;
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

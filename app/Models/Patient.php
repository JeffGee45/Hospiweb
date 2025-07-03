<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\Hospitalisation;
use App\Models\RendezVous;
use App\Models\Paiement;
use App\Models\User;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'numero_dossier',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'telephone',
        'email',
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['nom_complet', 'age', 'status_classes'];

    /**
     * Relation avec les consultations du patient
     */
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     * Relation avec la dernière consultation
     */
    public function latestConsultation()
    {
        return $this->hasOne(Consultation::class)->latestOfMany();
    }

    /**
     * Relation avec les rendez-vous du patient
     */
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    /**
     * Relation avec les hospitalisations du patient
     */
    public function hospitalisations()
    {
        return $this->hasMany(Hospitalisation::class);
    }

    /**
     * Relation avec les ordonnances du patient
     */
    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class);
    }

    /**
     * Relation avec les paiements du patient
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Get the user that owns the patient.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return trim("{$this->prenom} {$this->nom}");
    }

    /**
     * Accessor pour l'âge du patient
     */
    public function getAgeAttribute()
    {
        return $this->date_naissance ? $this->date_naissance->age : null;
    }
    
    /**
     * Accesseur pour les classes CSS du statut
     */
    public function getStatusClassesAttribute()
    {
        $classes = [
            'Actif' => 'bg-green-500 text-white',
            'Inactif' => 'bg-yellow-500 text-white',
            'Décédé' => 'bg-red-500 text-white',
        ];
        
        return $classes[$this->statut] ?? 'bg-gray-500 text-white';
    }

    /**
     * Scope pour les patients actifs
     */
    public function scopeActif($query)
    {
        return $query->where('statut', 'Actif');
    }

    /**
     * Scope pour la recherche
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('numero_dossier', 'like', "%{$search}%");
    }

    /**
     * Boot the model.
     */
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
     * Récupère la dernière consultation du patient
     */
    public function derniereConsultation()
    {
        return $this->hasOne(Consultation::class)->latest('date_consultation');
    }
}

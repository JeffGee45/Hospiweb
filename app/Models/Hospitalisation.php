<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Chambre;
use App\Models\Lit;
use App\Models\Assureur;
use App\Models\SoinInfirmier;

class Hospitalisation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'numero_dossier',
        'patient_id',
        'medecin_id',
        'chambre_id',
        'lit_id',
        'motif_hospitalisation',
        'diagnostic_entree',
        'diagnostic_sortie',
        'date_entree',
        'date_sortie_prevue',
        'date_sortie_reelle',
        'mode_entree', // programmée, urgence, transfert
        'mode_sortie', // guérison, amélioration, transfert, décès, abandom
        'mode_hebergement', // chambre individuelle, double, box
        'statut', // en_cours, sorti, transfert, decede
        'traitement',
        'examens_complementaires',
        'complications',
        'conduite_a_tenir',
        'contre_visite',
        'date_contre_visite',
        'observations',
        'transfert_vers',
        'motif_transfert',
        'est_urgence',
        'est_pris_en_charge',
        'type_prise_en_charge', // assurance, à titre payant, prise en charge partielle
        'assureur_id',
        'numero_prise_en_charge',
        'montant_garanti',
        'montant_deja_verse',
        'montant_restant',
        'accompagnant_nom',
        'accompagnant_lien',
        'accompagnant_telephone',
    ];

    protected $dates = [
        'date_entree',
        'date_sortie_prevue',
        'date_sortie_reelle',
        'date_contre_visite',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'examens_complementaires' => 'array',
        'complications' => 'array',
        'est_urgence' => 'boolean',
        'est_pris_en_charge' => 'boolean',
        'montant_garanti' => 'decimal:2',
        'montant_deja_verse' => 'decimal:2',
        'montant_restant' => 'decimal:2',
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

    public function chambre()
    {
        return $this->belongsTo(Chambre::class);
    }

    public function lit()
    {
        return $this->belongsTo(Lit::class);
    }

    public function assureur()
    {
        return $this->belongsTo(Assureur::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class);
    }

    public function soins()
    {
        return $this->hasMany(SoinInfirmier::class);
    }

    public function factures()
    {
        return $this->morphMany(Facture::class, 'facturable');
    }

    // Scopes
    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeSortis($query)
    {
        return $query->where('statut', 'sorti');
    }

    public function scopeUrgences($query)
    {
        return $query->where('est_urgence', true);
    }

    public function scopeParService($query, $serviceId)
    {
        return $query->whereHas('chambre', function($q) use ($serviceId) {
            $q->where('service_id', $serviceId);
        });
    }

    // Méthodes utilitaires
    public function getDureeSejourAttribute()
    {
        $dateFin = $this->date_sortie_reelle ?? now();
        $dateDebut = $this->date_entree;
        
        if (!$dateDebut) {
            return 'Non défini';
        }
        
        return $dateDebut->diffInDays($dateFin) . ' jours';
    }

    public function getStatutCouleurAttribute()
    {
        return [
            'en_cours' => 'bg-blue-100 text-blue-800',
            'sorti' => 'bg-green-100 text-green-800',
            'transféré' => 'bg-yellow-100 text-yellow-800',
            'décédé' => 'bg-red-100 text-red-800',
        ][$this->statut] ?? 'bg-gray-100 text-gray-800';
    }

    public function getEstEnCoursAttribute()
    {
        return $this->statut === 'en_cours';
    }

    public function getMontantTotalAttribute()
    {
        return $this->factures->sum('montant_total');
    }

    public function getResteAPayerAttribute()
    {
        return $this->montant_total - $this->factures->sum('montant_paye');
    }

    public function getEstSoldeeAttribute()
    {
        return $this->reste_a_payer <= 0;
    }

    // Événements du modèle
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($hospitalisation) {
            // Définir automatiquement la date d'entrée si non spécifiée
            if (!$hospitalisation->date_entree) {
                $hospitalisation->date_entree = now();
            }
            
            // Générer un numéro d'hospitalisation unique
            if (!$hospitalisation->numero_dossier) {
                $lastId = static::withTrashed()->max('id') ?? 0;
                $hospitalisation->numero_dossier = 'HOSP-' . date('Y') . '-' . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
            }
            
            // Si c'est une urgence, forcer le statut
            if ($hospitalisation->est_urgence) {
                $hospitalisation->mode_entree = 'urgence';
            }
        });

        static::updating(function ($hospitalisation) {
            // Si la date de sortie réelle est définie, mettre à jour le statut
            if ($hospitalisation->isDirty('date_sortie_reelle') && $hospitalisation->date_sortie_reelle) {
                if ($hospitalisation->mode_sortie === 'décès') {
                    $hospitalisation->statut = 'décédé';
                } elseif ($hospitalisation->mode_sortie === 'transfert') {
                    $hospitalisation->statut = 'transféré';
                } else {
                    $hospitalisation->statut = 'sorti';
                }
                
                // Libérer le lit
                if ($hospitalisation->lit) {
                    $hospitalisation->lit->update(['est_occupe' => false]);
                }
            }
            
            // Si le statut passe à "sorti" sans date de sortie, définir la date actuelle
            if ($hospitalisation->isDirty('statut') && $hospitalisation->statut === 'sorti' && !$hospitalisation->date_sortie_reelle) {
                $hospitalisation->date_sortie_reelle = now();
            }
        });
    }
}

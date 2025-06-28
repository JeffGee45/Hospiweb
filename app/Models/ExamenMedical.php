<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenMedical extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'consultation_id',
        'type_examen_id',
        'medecin_prescripteur_id',
        'technicien_id',
        'date_prescription',
        'date_realisation',
        'date_validation',
        'resultat',
        'observations',
        'statut', // ordonné, en_cours, terminé, validé, annulé
        'fichier_joint',
        'commentaire_technicien',
        'commentaire_medecin',
    ];

    protected $dates = [
        'date_prescription',
        'date_realisation',
        'date_validation',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relations
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function typeExamen()
    {
        return $this->belongsTo(TypeExamen::class, 'type_examen_id');
    }

    public function medecinPrescripteur()
    {
        return $this->belongsTo(User::class, 'medecin_prescripteur_id');
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    public function resultats()
    {
        return $this->hasMany(ResultatExamen::class, 'examen_id');
    }

    // Scopes
    public function scopeARealiser($query)
    {
        return $query->where('statut', 'ordonné');
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeTermines($query)
    {
        return $query->where('statut', 'terminé');
    }

    public function scopeValides($query)
    {
        return $query->where('statut', 'validé');
    }

    // Méthodes utilitaires
    public function getEstUrgentAttribute()
    {
        return $this->typeExamen->est_urgent ?? false;
    }

    public function getStatutCouleurAttribute()
    {
        return [
            'ordonné' => 'bg-blue-100 text-blue-800',
            'en_cours' => 'bg-yellow-100 text-yellow-800',
            'terminé' => 'bg-purple-100 text-purple-800',
            'validé' => 'bg-green-100 text-green-800',
            'annulé' => 'bg-red-100 text-red-800',
        ][$this->statut] ?? 'bg-gray-100 text-gray-800';
    }

    public function marquerCommeEnCours($technicienId)
    {
        $this->update([
            'statut' => 'en_cours',
            'technicien_id' => $technicienId,
            'date_realisation' => now()
        ]);
    }

    public function marquerCommeTermine(array $donneesResultat)
    {
        $this->update([
            'statut' => 'terminé',
            'resultat' => $donneesResultat['resultat'] ?? null,
            'observations' => $donneesResultat['observations'] ?? null,
            'date_realisation' => now()
        ]);
    }
}

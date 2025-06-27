<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RendezVous extends Model
{
    use SoftDeletes;

    protected $table = 'rendez_vouses';

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'secretaire_id',
        'date_rendez_vous',
        'duree_estimee', // en minutes
        'type_rendez_vous', // Consultation, Suivi, Examen
        'statut', // Programmé, Confirmé, Annulé, Manqué, Terminé
        'motif',
        'notes',
        'rappels_envoyes',
        'source_demande', // Téléphone, En ligne, Sur place
    ];

    protected $dates = [
        'date_rendez_vous',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'date_rendez_vous' => 'datetime',
        'duree_estimee' => 'integer',
        'rappels_envoyes' => 'boolean',
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

    public function secretaire()
    {
        return $this->belongsTo(User::class, 'secretaire_id');
    }

    // Scopes
    public function scopeAujourdhui($query)
    {
        return $query->whereDate('date_rendez_vous', today());
    }

    public function scopeDemain($query)
    {
        return $query->whereDate('date_rendez_vous', today()->addDay());
    }

    public function scopeCetteSemaine($query)
    {
        return $query->whereBetween('date_rendez_vous', [today()->startOfWeek(), today()->endOfWeek()]);
    }

    public function scopeProgrammes($query)
    {
        return $query->where('statut', 'Programmé');
    }

    public function scopeConfirmes($query)
    {
        return $query->where('statut', 'Confirmé');
    }

    public function scopeParMedecin($query, $medecinId)
    {
        return $query->where('medecin_id', $medecinId);
    }

    // Méthodes utilitaires
    public function getHeureDebutAttribute()
    {
        return $this->date_rendez_vous->format('H:i');
    }

    public function getHeureFinAttribute()
    {
        return $this->date_rendez_vous->addMinutes($this->duree_estimee)->format('H:i');
    }

    public function getStatutCouleurAttribute()
    {
        return [
            'Programmé' => 'bg-blue-100 text-blue-800',
            'Confirmé' => 'bg-green-100 text-green-800',
            'Annulé' => 'bg-red-100 text-red-800',
            'Manqué' => 'bg-gray-100 text-gray-800',
            'Terminé' => 'bg-purple-100 text-purple-800',
        ][$this->statut] ?? 'bg-gray-100 text-gray-800';
    }

    public function confirmer()
    {
        $this->update(['statut' => 'Confirmé']);
    }

    public function annuler($motif = null)
    {
        $this->update([
            'statut' => 'Annulé',
            'notes' => trim($this->notes . "\nAnnulé: " . ($motif ?? 'Aucun motif spécifié')),
        ]);
    }
}

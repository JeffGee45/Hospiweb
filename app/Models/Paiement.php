<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paiement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'facture_id',
        'montant',
        'date_paiement',
        'mode_paiement', // espèces, carte, virement, chèque
        'reference',
        'statut', // payé, annulé, remboursé
        'notes',
        'caissier_id',
    ];

    protected $dates = [
        'date_paiement',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relations
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }

    public function caissier()
    {
        return $this->belongsTo(User::class, 'caissier_id');
    }

    // Scopes
    public function scopePayes($query)
    {
        return $query->where('statut', 'payé');
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date_paiement', [$startDate, $endDate]);
    }
}

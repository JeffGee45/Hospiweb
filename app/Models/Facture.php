<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'numero_facture',
        'date_emission',
        'date_echeance',
        'statut',
        'montant_ht',
        'tva',
        'montant_ttc',
        'notes'
    ];

    protected $dates = [
        'date_emission',
        'date_echeance',
        'created_at',
        'updated_at'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function caissier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

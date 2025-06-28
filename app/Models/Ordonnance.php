<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ordonnance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'date_prescription',
        'date_expiration',
        'statut',
        'notes',
    ];

    protected $dates = [
        'date_prescription',
        'date_expiration',
        'created_at',
        'updated_at',
        'deleted_at'
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

    public function medicaments()
    {
        return $this->belongsToMany(Medicament::class, 'ordonnance_medicament')
            ->withPivot('posologie', 'duree', 'quantite', 'instructions')
            ->withTimestamps();
    }
}

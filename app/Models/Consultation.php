<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation extends Model
{
    use HasFactory;

    protected $casts = [
        'date_consultation' => 'datetime',
    ];

    protected $fillable = ['patient_id', 'medecin_id', 'date_consultation', 'notes', 'diagnostic'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }
}

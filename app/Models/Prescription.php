<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Consultation;
use App\Models\Medecin;
use App\Models\PrescriptionMedicament;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'medecin_id',
        'date_prescription',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public function medicaments()
    {
        return $this->hasMany(PrescriptionMedicament::class);
    }
}

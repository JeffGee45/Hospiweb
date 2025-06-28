<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Consultation;
use App\Models\User;
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
        return $this->belongsTo(User::class, 'medecin_id');
    }

    public function medicaments()
    {
        return $this->hasMany(PrescriptionMedicament::class);
    }
}

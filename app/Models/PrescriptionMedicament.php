<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prescription;
use App\Models\Medicament;

class PrescriptionMedicament extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'medicament_id',
        'nom_medicament',
        'dosage',
        'duree',
        'frequence',
        'quantite',
        'instructions',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medicament()
    {
        return $this->belongsTo(Medicament::class);
    }
}

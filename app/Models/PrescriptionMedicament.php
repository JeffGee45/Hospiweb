<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prescription;

class PrescriptionMedicament extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'nom_medicament',
        'dosage',
        'duree',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}

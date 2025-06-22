<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Patient;

class Hospitalisation extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'date_entree', 'date_sortie', 'chambre', 'traitement_suivi'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

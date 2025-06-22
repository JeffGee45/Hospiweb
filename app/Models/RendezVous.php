<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vouses';

    protected $fillable = [
        'patient_id',
        'user_id',
        'date_rendez_vous',
        'statut',
        'motif',
    ];

    protected $casts = [
        'date_rendez_vous' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultatExamen extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'examen_id',
        'parametre_id',
        'valeur',
        'unite_mesure',
        'valeur_min',
        'valeur_max',
        'est_normal',
        'commentaire',
        'valide_par',
        'date_validation',
    ];

    protected $dates = [
        'date_validation',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'valeur' => 'float',
        'valeur_min' => 'float',
        'valeur_max' => 'float',
        'est_normal' => 'boolean',
    ];

    // Relations
    public function examen()
    {
        return $this->belongsTo(ExamenMedical::class, 'examen_id');
    }

    public function parametre()
    {
        return $this->belongsTo(ParametreExamen::class, 'parametre_id');
    }

    public function validateur()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    // Méthodes utilitaires
    public function getValeurFormateeAttribute()
    {
        if (is_numeric($this->valeur)) {
            return rtrim(rtrim(number_format($this->valeur, 2, '.', ' '), '0'), '.') . ' ' . $this->unite_mesure;
        }
        return $this->valeur . ($this->unite_mesure ? ' ' . $this->unite_mesure : '');
    }

    public function getIntervalleNormalAttribute()
    {
        if ($this->valeur_min !== null && $this->valeur_max !== null) {
            return $this->valeur_min . ' - ' . $this->valeur_max . ' ' . $this->unite_mesure;
        }
        return 'N/A';
    }

    public function getStatutCouleurAttribute()
    {
        if ($this->est_normal === null) {
            return 'bg-gray-100 text-gray-800';
        }
        return $this->est_normal 
            ? 'bg-green-100 text-green-800' 
            : 'bg-red-100 text-red-800';
    }
}

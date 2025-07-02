<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParametreExamen extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'type_examen_id',
        'code',
        'nom',
        'description',
        'unite_mesure',
        'valeur_normale_min',
        'valeur_normale_max',
        'est_actif',
        // Ajoutez ici les autres champs utilisés dans la base
    ];


    protected $casts = [
        'valeur_min' => 'float',
        'valeur_max' => 'float',
        'valeur_min_urgent' => 'float',
        'valeur_max_urgent' => 'float',
        'masculin_valeur_min' => 'float',
        'masculin_valeur_max' => 'float',
        'feminin_valeur_min' => 'float',
        'feminin_valeur_max' => 'float',
        'enfant_valeur_min' => 'float',
        'enfant_valeur_max' => 'float',
        'adulte_valeur_min' => 'float',
        'adulte_valeur_max' => 'float',
        'est_obligatoire' => 'boolean',
        'est_actif' => 'boolean',
        'options_liste' => 'array',
        'personnalise_valeurs_normales' => 'boolean',
    ];

    // Relations
    public function typeExamen()
    {
        return $this->belongsTo(TypeExamen::class, 'type_examen_id');
    }

    public function resultats()
    {
        return $this->hasMany(ResultatExamen::class, 'parametre_id');
    }


    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('est_actif', true);
    }

    public function scopeObligatoires($query)
    {
        return $query->where('est_obligatoire', true);
    }

    public function scopeParTypeExamen($query, $typeExamenId)
    {
        return $query->where('type_examen_id', $typeExamenId);
    }

    // Méthodes utilitaires
    public function getNomCompletAttribute()
    {
        return $this->code ? "{$this->code} - {$this->nom}" : $this->nom;
    }

    public function getValeursNormalesAttribute()
    {
        if ($this->personnalise_valeurs_normales) {
            // Logique pour déterminer les valeurs en fonction du sexe et de l'âge
            // À implémenter selon les besoins spécifiques
            return [
                'min' => $this->valeur_min,
                'max' => $this->valeur_max,
                'unite' => $this->unite_mesure
            ];
        }
        
        return [
            'min' => $this->valeur_min,
            'max' => $this->valeur_max,
            'unite' => $this->unite_mesure
        ];
    }

    public function getValeursNormalesTexteAttribute()
    {
        if ($this->type_donnee === 'numerique') {
            $valeurs = $this->valeurs_normales;
            return "{$valeurs['min']} - {$valeurs['max']} {$valeurs['unite']}";
        }
        
        return $this->valeur_texte_par_defaut ?? 'N/A';
    }

    public function getEstValeurNormale($valeur, $sexe = null, $age = null)
    {
        if ($valeur === null) {
            return null;
        }

        $valeurs = $this->getValeursNormalesAttribute($sexe, $age);
        
        if ($this->type_donnee === 'numerique') {
            return $valeur >= $valeurs['min'] && $valeur <= $valeurs['max'];
        }
        
        // Pour les types non numériques, on considère que c'est normal s'il y a une valeur
        return !empty($valeur);
    }
}

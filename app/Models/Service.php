<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'nom',
        'description',
        'chef_service_id',
        'batiment',
        'etage',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    // Relations
    public function chefService()
    {
        return $this->belongsTo(User::class, 'chef_service_id');
    }

    public function chambres()
    {
        return $this->hasMany(Chambre::class);
    }

    public function medecins()
    {
        return $this->hasMany(User::class);
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('est_actif', true);
    }

    // Méthodes utilitaires
    public function getNomCompletAttribute()
    {
        return $this->code ? "{$this->code} - {$this->nom}" : $this->nom;
    }
}

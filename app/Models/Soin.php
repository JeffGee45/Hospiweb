<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Soin extends Model
{
    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'hospitalisation_id',
        'type_soin',
        'description',
        'date_soin',
        'signes_vitaux',
        'notes',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_soin' => 'datetime',
        'signes_vitaux' => 'array',
    ];

    /**
     * Obtenez l'utilisateur qui a effectué le soin.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenez l'hospitalisation associée au soin.
     */
    public function hospitalisation(): BelongsTo
    {
        return $this->belongsTo(Hospitalisation::class);
    }

    /**
     * Obtenez les notes médicales associées au soin.
     */
    public function notesMedicales(): HasMany
    {
        return $this->hasMany(NoteMedicale::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteMedicale extends Model
{
    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'user_id',
        'soin_id',
        'note',
    ];

    /**
     * Obtenez le patient concerné par la note.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Obtenez l'utilisateur qui a rédigé la note.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenez le soin associé à la note.
     */
    public function soin(): BelongsTo
    {
        return $this->belongsTo(Soin::class);
    }
}

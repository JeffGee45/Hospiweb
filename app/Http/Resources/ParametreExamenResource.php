<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParametreExamenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'nom' => $this->nom,
            'unite_mesure' => $this->unite_mesure,
            'valeur_normale_min' => $this->valeur_normale_min,
            'valeur_normale_max' => $this->valeur_normale_max,
            'description' => $this->description,
            'est_actif' => $this->est_actif,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type_examen_id' => $this->type_examen_id,
        ];
    }
}

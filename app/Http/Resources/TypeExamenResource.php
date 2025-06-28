<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeExamenResource extends JsonResource
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
            'description' => $this->description,
            'categorie' => $this->categorie,
            'prix' => $this->prix,
            'prix_formate' => $this->prix_formate,
            'duree_moyenne' => $this->duree_moyenne,
            'duree_formatee' => $this->duree_formatee,
            'preparation_requise' => $this->preparation_requise,
            'est_actif' => $this->est_actif,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'parametres' => ParametreExamenResource::collection($this->whenLoaded('parametres')),
        ];
    }
}

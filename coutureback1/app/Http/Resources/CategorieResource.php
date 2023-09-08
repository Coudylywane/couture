<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return  [
            'id'=>$this->id,
            'libelle'=> $this->libelle,
            "unite_default"=> ["id"=>$this->unites[0]->id,
            "libelle"=>$this->unites[0]->libelle,
            "etat"=>$this->unites[0]->pivot->etat],
        ];

    }
}
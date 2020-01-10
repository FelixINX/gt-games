<?php

namespace App\Http\Resources\Scatt;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GameHomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'timer' => $this->timer,
            'numberOfRounds' => $this->number_of_rounds,
            'user' => UserResource::make($this->user),
            'rounds' => count($this->rounds),
            'categories' => count($this->categories)
        ];
    }
}

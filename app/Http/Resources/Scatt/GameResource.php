<?php

namespace App\Http\Resources\Scatt;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'userId' => $this->user_id,
            'active' => $this->active,
            'started' => $this->started,
            'currentState' => $this->state,
            'rounds' => RoundResource::collection($this->rounds),
            'categories' => CategoryResource::collection($this->categories),
            'users' => UserResource::collection($this->users),
            'activeRound' => RoundResource::make($this->activeRound)
        ];
    }
}

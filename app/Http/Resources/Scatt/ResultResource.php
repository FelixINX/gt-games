<?php

namespace App\Http\Resources\Scatt;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'reputation' => (object) $this->users_reputation,
            'users' => UserResource::collection($this->users)
        ];
    }
}

<?php

namespace App\Http\Resources\Scatt;

use Illuminate\Http\Resources\Json\JsonResource;

class RoundResource extends JsonResource
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
            'done' => $this->done,
            'letter' => $this->letter,
            'approval' => (object) $this->user_approval
        ];;
    }
}

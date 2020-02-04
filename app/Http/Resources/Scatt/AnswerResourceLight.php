<?php

namespace App\Http\Resources\Scatt;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResourceLight extends JsonResource
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
            'approved' => $this->approved,
            'approval' => (object) $this->user_approval,
            'categoryId' => $this->category_id,
            'id' => $this->id
        ];
    }
}

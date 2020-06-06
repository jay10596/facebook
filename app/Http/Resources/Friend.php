<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Friend extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'confirmed_at' => optional($this->confirmed_at)->diffForHumans(), //optional is used for the fields which are nullable
            'path' => url('/users/'.$this->friend_id)
        ];
    }
}

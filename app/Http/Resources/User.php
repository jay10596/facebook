<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Friend as FriendResource;

use App\Friend;

class User extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'friendship' => new FriendResource(Friend::friendship($this->id)),
            'path' => $this->path
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'post_id' => $this->post_id,
            'updated_at' => $this->updated_at->diffForHumans(),

            'commented_by' => new UserResource($this->user),

            'path' => url('/posts/' . $this->post_id . '/comments/' . $this->id),
        ];
    }
}

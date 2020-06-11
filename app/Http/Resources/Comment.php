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
            'created_at' => $this->created_at->diffForHumans(),

            'commented_by' => new UserResource($this->user),

            'path' => url('/posts/' . $this->post_id . '/comments/' . $this->id),
        ];
    }
}

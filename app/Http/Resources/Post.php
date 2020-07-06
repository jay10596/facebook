<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Picture as PictureResource;


class Post extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->diffForHumans(),

            'single_picture' => new PictureResource($this->singlePicture),

            'likes' => new LikeCollection($this->likes),

            'comments' => new CommentCollection($this->comments),

            'posted_by' => new UserResource($this->user),

            'path' => $this->path,
        ];
    }
}

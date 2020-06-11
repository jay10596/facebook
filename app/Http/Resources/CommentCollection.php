<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'comment_count' => $this->count(),
            'links' => [
                'self' => url('/posts'),
            ],
        ];
    }
}

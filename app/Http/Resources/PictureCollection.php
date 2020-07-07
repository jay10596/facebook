<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PictureCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'picture_count' => $this->count(),
            'links' => [
                'self' => '/posts',
            ],
        ];
    }
}

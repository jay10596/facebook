<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Picture extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'type' => $this->type,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends JsonResource
{

    public function toArray($request)
    {

        return [
            'lawyer_id' => $this->lawyer_id,
            'user_id' => $this->user_id,
            'rate' => $this->review,
            'comment' => $this->comment,
            'created_at' => $this->created_at->format('Y-m-d'),
            'user_image' => $this->image,
        ];

    }
}

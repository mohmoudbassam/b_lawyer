<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkingHoursCollection extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'day' => $this->day,
            'from' => $this->from,
            'to' => $this->to,
        ];
    }
}

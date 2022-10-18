<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LawyerReservationResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserForReservationResource($this->user),
            'date' => Carbon::parse($this->date)->format('Y-m-d'),
            'status' => $this->status,

        ];
    }
}

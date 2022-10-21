<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LawyerForReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? '',
            'name' => $this->name ?? '',
            'phone' => $this->phone ?? '',
            'mobile' => $this->mobile ?? '',
            'image' => $this->image ?? '',
            'type' => $this->type ?? '',
            'lawyer_type' => $type_of_lawyer ?? '',
            'lat' => $this->lat ?? '',
            'long' => $this->long ?? '',
            'city' => $this->city->name ?? '',
            'about_me' => $this->about_me,
            'address' => $this->address,
            'age' => $this->age,
            'gender' => $this->gender,
        ];
    }
}

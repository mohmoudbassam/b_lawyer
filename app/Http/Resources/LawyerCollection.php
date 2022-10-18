<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class LawyerCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if ($this->type=='lawyer') {
            $type_of_lawyer = optional($this->type_of_lawyer)->getTranslation('name','ar');

        } else {
            $type_of_lawyer = $this->office_type->pluck('name')->toArray();
        }

        $data = [
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
        if ($this->access_token) {
            $data['access_token'] = $this->access_token;
        }
        return $data;
    }
}

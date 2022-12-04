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

        if ($this->type == 'lawyer') {
            $type_of_lawyer = optional($this->type_of_lawyer)->getTranslation('name', 'ar');

        } else {
            $type_of_lawyer = $this->office_type->pluck('name')->toArray();
        }

        $data = [
            'id' => $this->id ?? '',
            'name' => $this->name ?? '',
            'phone' => $this->phone ?? '',
            'mobile' => $this->mobile ?? '',
            'email' => $this->email ?? '',
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
            'instagram' => $this->instagram,
            'tiktok' => $this->tiktok,
            'whats_up' => $this->whats_up,
            'facebook' => $this->facebook,
            'reviews'=>$this->review()->avg('review') ?? 0,
            'certificates'=>$this->certificates ?? '',
            'experience'=>$this->experience ?? '',
            'majors'=>$this->majors ?? '',
            'union_bound'=>$this->union_bound ?? '',
        ];
        if ($this->access_token) {
            $data['access_token'] = $this->access_token;
        }
        if ($this->type == 'lawyer') {
            $data['identity_image'] = isset($this->identity_image) ? asset('storage/' . $this->identity_image) : '';
            $data['identity_number'] = $this->identity_number;
        }
        if ($this->type == 'office') {
            $data['license_number'] = $this->license_number;
            $data['license_image'] = isset($this->license_image) ? asset('storage/' . $this->license_image) : '';;
        }
        return $data;
    }
}

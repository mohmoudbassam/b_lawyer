<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id ?? '',
            'name' => $this->name ?? '',
            'email' => $this->email ?? '',
            'mobile' => $this->phone ?? '',
            'image' => $this->image ?? '',
            'type' => $this->type ?? '',
            'about_me' => $this->about_me ?? '',
            'address' => $this->address ?? '',
        ];
        if ($this->access_token) {
            $data['access_token'] = $this->access_token;
        }
        return $data;
    }
}

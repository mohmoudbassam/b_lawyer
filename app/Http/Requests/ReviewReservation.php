<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewReservation extends BaseRequest
{

    public function rules()
    {
        return [
            'reservation_id' => [
                'required',
                Rule::exists('reservations', 'id')->where(function ($query) {
                    $query->where('user_id', auth('users')->user()->id());
                }),
            ],
        ];
    }
}

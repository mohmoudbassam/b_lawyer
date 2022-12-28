<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompeleteReservation extends BaseRequest
{

    public function rules()
    {
        return [
            'reservation_id' =>[
                'required',
                Rule::exists('reservations','id')
                    ->where('lawyer_id',auth('users')->user()->getKey())
            ],
        ];
    }
}

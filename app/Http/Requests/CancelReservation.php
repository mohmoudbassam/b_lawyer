<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelReservation extends BaseRequest
{

    public function rules()
    {
        return [
            'reservation_id' => 'required|exists:reservations,id',
        ];
    }


}

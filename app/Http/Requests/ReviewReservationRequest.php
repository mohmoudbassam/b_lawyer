<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewReservationRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'reservation_id' => [
                'required',
                Rule::exists('reservations', 'id')->where('user_id', auth('users')->id()),
            ],
            'review' => [
                'required',
                Rule::in([1, 2, 3, 4, 5])
            ],
        ];
    }
}

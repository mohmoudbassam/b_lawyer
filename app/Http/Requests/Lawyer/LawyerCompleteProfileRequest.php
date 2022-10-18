<?php

namespace App\Http\Requests\Lawyer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LawyerCompleteProfileRequest extends FormRequest
{

    public function rules()
    {
        return [
            'phone' => [
                'nullable',
                'between:9,14',
                Rule::unique('users', 'phone')->ignore(auth('users')->id())
            ],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore(auth('users')->id())
            ],
            'name' => [
                'nullable',
                'string',
            ],

            'password' => [
                'nullable',
                'string',
            ],
            'city_id' => [
                'required',
                Rule::exists('cities', 'id')
            ],
            'lawyer_type' => [
                'nullable',
                Rule::exists('lawyer_types', 'id')
            ],

        ];
    }
}

<?php

namespace App\Http\Requests;


use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'phone' => [
                'required',
                'between:9,14',
                Rule::unique('users', 'phone')->ignore(auth('users')->id())
            ],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore(auth('users')->id())
            ],
            'name' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
            ], 'type' => [
                'required',
               Rule::in(['user', 'lawyer', 'office']),
            ],

        ];
    }
}



<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'password' => 'required|min:8',
            'code' => [
                'required',
                Rule::exists('users', 'reset_password_code')->where(function ($query) {
                    $query->where('phone', request()->phone);
                }),
            ]
        ];
    }
}

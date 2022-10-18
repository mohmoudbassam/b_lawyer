<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'phone' => 'required',
            'password' => 'required',
        ];

    }
}

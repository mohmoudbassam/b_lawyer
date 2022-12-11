<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class SocialLoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'token' => [
                'required',
                'string'
            ],
        ];
    }
}

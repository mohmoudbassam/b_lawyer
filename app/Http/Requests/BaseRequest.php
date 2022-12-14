<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(api(false, 400, __('api.validation_error'))
            ->add('errors', array_combine($validator->errors()->keys(), $validator->errors()->all()))
            ->get());
    }
}

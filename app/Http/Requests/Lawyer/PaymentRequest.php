<?php

namespace App\Http\Requests\Lawyer;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'plan_id'=>[
                'required',
                Rule::exists('plans','id')
            ],
            
        ];
    }
}

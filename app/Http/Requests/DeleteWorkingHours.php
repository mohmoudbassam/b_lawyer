<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteWorkingHours extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                Rule::exists('working_hours','id')->where(function ($query) {
                    $query->where('lawyer_id', auth('users')->user()->getKey());
                }),
            ],

        ];
    }
}

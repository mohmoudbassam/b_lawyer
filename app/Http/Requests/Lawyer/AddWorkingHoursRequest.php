<?php

namespace App\Http\Requests\Lawyer;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddWorkingHoursRequest extends BaseRequest
{

    public function rules()
    {
        $days = collect(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']);

        return [

            'dates' => [
                'required',
                'array'
            ],
            'dates.*' => [
                'required',
                'array',
               // Rule::in(['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
            ],
            'dates.*.from_time' => [
                'required',
                'string',
                'date_format:H:i'
            ],
            'dates.*.to_time' => [
                'required',
                'string',
                'date_format:H:i'
            ],
        ];
    }
}

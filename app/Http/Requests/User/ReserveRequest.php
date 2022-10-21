<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReserveRequest extends BaseRequest
{

    public function rules()
    {

        return [
            'lawyer_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->whereIn('type', ['lawyer', 'office']);
                })->where('enabled', 1),
            ],
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ];
    }
}

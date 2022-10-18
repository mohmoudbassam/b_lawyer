<?php

namespace App\Http\Controllers\Api\Constant;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;
use App\Models\City;
use App\Models\LawyerType;
use Illuminate\Http\Request;

class ConstantsController extends Controller
{
    public function cities()
    {
        return api(true, 200, __('api.success'))
            ->add('cities', CityCollection::collection(City::all()))
            ->get();
    }

    public function lawyer_types()
    {
        return api(true, 200, __('api.success'))
            ->add('cities', CityCollection::collection(LawyerType::all()))
            ->get();
    }
}

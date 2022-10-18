<?php

namespace App\Http\Controllers\Api\Lawyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lawyer\LawyerCompleteProfileRequest;
use App\Http\Resources\LawyerCollection;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function complete_profile(LawyerCompleteProfileRequest $request)
    {

        auth('users')->user()->update([
            'name' => $request['name'] ?? auth('users')->user()->name,
            'email' => $request['email'] ?? auth('users')->user()->email,
//            'password' => Hash::make($request['password']),
            'phone' => $request['phone'] ?? auth('users')->user()->phone,
            'about_me' => $request['about_me'] ?? auth('users')->user()->about_me,
            'address' => $request['address'] ?? auth('users')->user()->address,
            'age' => $request['age'] ?? auth('users')->user()->age,
            'gender' => $request['gender'] ?? auth('users')->user()->gender,
            'city_id' => $request['city_id'] ?? auth('users')->user()->city_id,
            'lat' => $request['lat'] ?? auth('users')->user()->lat,
            'long' => $request['long'] ?? auth('users')->user()->long,
            'lawyer_type' => !is_array($request['lawyer_type']) ?? auth('users')->user()->lawyer_type,
        ]);

        if (auth('users')->user()->type == 'office') {
            auth('users')->user()->office_type()->sync($request['lawyer_types']);
        }
        if ($request->image) {
            $image = $request->image;
            $path = $image->store('users', 'public');
            auth('users')->user()->update([
                'image' => $path
            ]);
        }

        return api(true, 200, __('api.success'))
            ->add('user', new LawyerCollection(auth('users')->user()))
            ->get();
    }

    public function me()
    {
        return api(true, 200, __('api.success'))
            ->add('user', new LawyerCollection(auth('users')->user()))
            ->get();
    }
}

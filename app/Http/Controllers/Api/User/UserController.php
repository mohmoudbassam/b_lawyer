<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\LawyerCollection;
use App\Http\Resources\LawyerReservationResource;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\UserCollection;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update_profile(Request $request)
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
            'lawyer_type' => (!is_array($request['lawyer_type']) && !is_null(request('lawyer_type'))) ? request('lawyer_type') : auth('users')->user()->lawyer_type,
            'tiktok' => $request['tiktok'] ?? auth('users')->user()->tiktok,
            'whats_up' => $request['whats_up'] ?? auth('users')->user()->whats_up,
            'facebook' => $request['facebook'] ?? auth('users')->user()->facebook,
            'instagram' => $request['instagram'] ?? auth('users')->user()->instagram,
            'license_number' => $request['license_number'] ?? auth('users')->user()->license_number,
            'identity_number' => $request['identity_number'] ?? auth('users')->user()->identity_number,
            'certificates' => $request['certificates'] ?? auth('users')->user()->certificates,
            'experience' => $request['experience'] ?? auth('users')->user()->experience,
            'majors' => $request['majors'] ?? auth('users')->user()->majors,
            'union_bound' => $request['union_bound'] ?? auth('users')->user()->union_bound,
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
        if ($request->identity_image) {
            $image = $request->identity_image;
            $path = $image->store('users', 'public');
            auth('users')->user()->update([
                'identity_image' => $path
            ]);
        }
        if ($request->license_image) {
            $image = $request->license_image;
            $path = $image->store('users', 'public');
            auth('users')->user()->update([
                'license_image' => $path
            ]);
        }

        return api(true, 200, __('api.success'))
            ->add('user', new UserCollection(auth('users')->user()))
            ->get();
    }

    public function get_reviews(Request $request)
    {

      $reviews=  Review::query()
          ->where('lawyer_id',$request->lawyer_id)
          ->paginate(request('per_page') ?? 10);

      $lawyer=User::query()->where('id',$request->lawyer_id)->first()->review()->avg('review');
        return api(true, 200, __('api.success'))
            ->add('reviews', ReviewCollection::collection($reviews),$reviews)
            ->add('total_review',$lawyer)
            ->get();
    }
}

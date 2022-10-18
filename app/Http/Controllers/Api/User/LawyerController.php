<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReserveRequest;
use App\Http\Resources\LawyerCollection;
use App\Models\User;
use Illuminate\Http\Request;

class LawyerController extends Controller
{
    public function list(Request $request)
    {

        $lawyers = User::query()
            ->where(function ($q) {
                $q->where('type', 'lawyer')->orWhere('type', 'office');
            })->where('enabled', 1)
            ->whenName($request->name)
            ->whenCity($request->city_id)
            ->whenId($request->id)
            ->whenTypeOfLawyer($request->type_of_lawyer)
            ->paginate(request('per_page') ?? 10);

        if ($request->id) {
            return api(true, 200, __('api.success'))
                ->add('lawyers', new LawyerCollection($lawyers->first()))
                ->get();
        }
        return api(true, 200, __('api.success'))
            ->add('lawyers', LawyerCollection::collection($lawyers), $lawyers)
            ->get();
    }

    public function reserve(ReserveRequest $request)
    {
        $lawyer = User::query()->find($request->lawyer_id);

        if (auth('users')->user()->reservations()->whereDate('date', $request->date)->exists()) {
            return api(false, 400, __('api.you_can_not_reserve_on_same_day'))->get();
        }
        auth('users')->user()->reservations()->create([
            'lawyer_id' => $lawyer->id,
            'date' => $request->date,
            'status' => 'pending',
        ]);

        return api(true, 200, __('api.success'))->get();
    }
}

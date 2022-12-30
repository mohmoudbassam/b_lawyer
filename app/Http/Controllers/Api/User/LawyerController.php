<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CancelReservation;
use App\Http\Requests\ReviewReservationRequest;
use App\Http\Requests\User\ReserveRequest;
use App\Http\Resources\LawyerCollection;
use App\Http\Resources\UserReservation;
use App\Http\Resources\WorkingHoursCollection;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use App\Models\WorkingHours;
use Carbon\Carbon;
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
            ->whenRateSort($request->sort)
            ->whenCity($request->city_id)
            ->whenId($request->id)
            ->whenTypeOfLawyer($request->type)
        //    ->whereLawyerEnabled()
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

    public function lawyer_working_hours(Request $request)
    {
        $lawyer = User::query()->where('id', $request->lawyer_id)
         //   ->whereLawyerEnabled()
            ->firstOrFail();

        $working_hours = WorkingHours::query()->where('lawyer_id', $lawyer->id)->get();
        return api(true, 200, __('api.success'))
            ->add('working_hours', WorkingHoursCollection::collection($working_hours))
            ->get();
    }


    public function reserve_appointment(ReserveRequest $request)
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

    public function my_reservation()
    {
        $reservations = Reservation::query()->where('user_id', auth('users')->user()->getKey())
            ->whenStatus(request('status'))
            ->get();
        return api(true, 200, __('api.success'))
            ->add('reservations', UserReservation::collection($reservations))
            ->get();
    }

    public function cancel_reservation(CancelReservation $request)
    {
        $reservation = Reservation::query()->where('user_id', auth('users')->user()->getKey())
            ->where('id', $request->reservation_id)
            ->firstOrFail();

        if ($reservation->status == 'canceled') {
            return api(false, 400, __('api.already_canceled'))->get();
        }

        if ($reservation->date < Carbon::now()->toDateString()) {
            return api(false, 400, __('api.can_not_cancel'))->get();
        }
        if ($reservation->status == 'accepted' || $reservation->date < Carbon::now()->toDateString()) {
            return api(false, 400, __('api.can_not_cancel'))->get();
        }

        $reservation->update([
            'status' => 'canceled',
        ]);

        return api(true, 200, __('api.success'))->get();
    }

    public function review_reservation(ReviewReservationRequest $request)
    {
        $review = Review::query()->where('reservation_id', '=', $request->reservation_id)->first();

        if ($review) {
            return api(false, 400, __('api.already_reviewed'))->get();
        }
        $reservation = Reservation::query()->find($request->reservation_id);
       Review::query()->create([
            'reservation_id' => $request->reservation_id,
            'review' => $request->review,
            'lawyer_id' => $reservation->lawyer_id,
           'user_id'=>auth('users')->user()->id,
           'comment'=>$request->comment,
        ]);

        return api(true, 200, __('api.success'))->get();
    }

    public function subscription_lawyers(){
        $lawyers = User::query()
            ->where(function ($q) {
                $q->where('type', 'lawyer')
                    ->orWhere('type', 'office');
            })->where('enabled', 1)
           ->whereLawyerEnabled()
            ->paginate(request('per_page') ?? 10);
        return api(true, 200, __('api.success'))
            ->add('lawyers', LawyerCollection::collection($lawyers), $lawyers)
            ->get();
    }


}

<?php

namespace App\Http\Controllers\Api\Lawyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteWorkingHours;
use App\Http\Requests\Lawyer\AddWorkingHoursRequest;
use App\Http\Requests\Lawyer\LawyerCompleteProfileRequest;
use App\Http\Resources\CityCollection;
use App\Http\Resources\LawyerCollection;
use App\Http\Resources\LawyerReservationResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\WorkingHoursCollection;
use App\Models\LawyerType;
use App\Models\Reservation;
use App\Models\WorkingHours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AppointmentController extends Controller
{

    public function add_workings_hours(AddWorkingHoursRequest $request)
    {

        foreach ($request->dates as $day => $value) {
            WorkingHours::query()->updateOrCreate(['lawyer_id' => auth('users')->user()->getKey(), 'day' => $day], [
                'lawyer_id' => auth('users')->user()->getKey(),
                'day' => $day,
                'from' => $value['from_time'],
                'to' => $value['to_time'],
            ]);
        }

        $working_hours = WorkingHours::query()->where('lawyer_id', auth('users')->user()->getKey())->get();
        return api(true, 200, __('api.success'))
            ->add('working_hours', WorkingHoursCollection::collection($working_hours))
            ->get();
    }

    public function delete_workings_hours(DeleteWorkingHours $deleteWorkingHours)
    {
        WorkingHours::query()->where('id', $deleteWorkingHours->id)->delete();
        return api(true, 200, __('api.success'))->get();
    }

    public function get_workings_hours()
    {
        $working_hours = WorkingHours::query()->where('lawyer_id', auth('users')->user()->getKey())->get();
        return api(true, 200, __('api.success'))
            ->add('working_hours', WorkingHoursCollection::collection($working_hours))
            ->get();
    }

    public function my_reservations()
    {

        $reservations = Reservation::query()
            ->where('lawyer_id', auth('users')->user()->getKey())
            ->whenStatus(request('status'))
            ->paginate(request('per_page') ?? 10);
        return api(true, 200, __('api.success'))
            ->add('reservations', LawyerReservationResource::collection($reservations),$reservations)
            ->get();
    }
}

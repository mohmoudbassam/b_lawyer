<?php

namespace App\Http\Controllers\Api\Lawyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lawyer\PaymentRequest;
use App\Http\Resources\PlanResource;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function list()
    {
        $palns = Plan::all();

        return api('success', 200, 'api.success')
            ->add('plans', PlanResource::collection($palns))->get();
    }

    public function payment(PaymentRequest $request)
    {
        $plan = Plan::find($request->plan_id);
        $payment = Payment::query()->create([
            'user_id' => auth('users')->id(),
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => 'pending',
        ]);
        $response = payment($plan, route('after_payment', $payment));
        dd($response);
        if (!isset($response->tran_ref)) {
            return api('error', 400, 'api.error')->get();
        }
        $payment->update([
            'payment_id' => $response->tran_ref
        ]);

        return api('success', 200, 'api.success')
            ->add('payment_url', $response->redirect_url)->get();
    }
}

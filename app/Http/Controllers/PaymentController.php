<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function after_payment($payment_id)
    {
        $payment = Payment::query()->findOrFail($payment_id);
        $payment->status = 'success';
        $payment->save();
        $result = follow_up_transaction($payment->payment_id);

        if ($result->tran_ref) {
            $payment->user->update([
                'enabled_to' => $payment->plan->extension_until(),
                'enabled' => 1,
            ]);
            return api('success', 200, 'api.success')->get();
        } else {
            return api('error', 400, 'api.error')->get();
        }
    }

}

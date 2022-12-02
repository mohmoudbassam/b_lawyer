<?php

use App\Helpers\APIResponse;
use App\Models\Center;
use App\Models\Doctor;
use App\Models\DoctorsDates;
use App\Models\OffersOrders;
use App\Models\Order;
use App\Models\Setting;
use App\Services\TabbyService;
use App\Services\TamaraService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

function api($success, $code, $message, $items = null, $errors = null)
{
    return new APIResponse($success, $code, $message);
}

function api_exception(Exception $e)
{
    return api(false, $e->getCode(), $e->getMessage())
        ->add('error', [
            'line' => $e->getLine(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'trace' => $e->getTrace(),
        ])->get();
}

function localURL($url)
{
    return url(app()->getLocale() . '/' . $url);
}

function locale()
{
    return app()->getLocale();
}

function direction()
{
    return locale() == 'ar' ? '.rtl' : '';
}

function isRTL()
{
    return locale() == 'ar';
}

function upload_file($file, $folder)
{
    $ex = $file->getClientOriginalExtension();

    return 'uploads/' . $file->storeAs($folder, time() . Str::random(30) . '.' . $ex);
}

function language($en, $ar)
{
    return app()->getLocale() == 'ar' ? $ar : $en;
}

function settings($key)
{
    return Setting::query()->first()->{$key};
}

function payment($plan, $url)
{
    $curl = curl_init();

    $server_key = env('PAYMENT_SERVER_KEY');
    $data = [
        "profile_id" => 105693,
        "tran_type" => "sale",
        "tran_class" => "ecom",
        "cart_id" => Str::uuid(),
        "cart_description" => "Dummy Order 35925502061445345",
        "cart_currency" => "EGP",
        "cart_amount" => $plan->price,
        "callback" => $url,
        "return" => $url,
        "framed" => true,

    ];
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://secure-egypt.paytabs.com/payment/request',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'authorization: ' . $server_key,
            'content-type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);

}

function follow_up_transaction($tran_ref)
{
    $curl = curl_init();
    $server_key = env('PAYMENT_SERVER_KEY');
    $data = [
        "profile_id" => '105693',
        "tran_ref" => $tran_ref
    ];
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://secure-egypt.paytabs.com/payment/query',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'authorization: ' . $server_key,
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response);
}

function send_verifcation_code($phone, $code)
{
    $data = [
        'username' => 'mohamedhawary9494@gmail.com',
        'password' => '9BAE98*vI',
        'sendername' => 'afocato',
        'mobiles' => $phone,
        'message' => 'Your verification code is ' . $code,
    ];
    $data = collect($data)->map(function ($key, $value) {
        return $value . '=' . $key;
    })->implode('&');

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://smssmartegypt.com/sms/api/?' . $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Accept-Language: en-US'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response);

}



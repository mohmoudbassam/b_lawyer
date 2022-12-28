<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SendCodeRequest;
use App\Http\Requests\SocialLoginRequest;
use App\Http\Resources\UserCollection;
use App\Models\Code;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Lcobucci\JWT\Token\Parser;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::query()->where('phone', $request['phone'])->first();

        if (!$user)
            return api(false, 400, __('constants.loginErr'))->get();
        if (!Hash::check($request['password'], $user->password))
            return api(false, 400, __('constants.loginErr'))->get();


        $tokenResult = $user->createToken('users', ['users']);
        $token = $tokenResult->token;
        $token->save();
        $response = api(true, 200, __('api.success_login'))
            ->add('user', new UserCollection($user));

        if ($user->isLawyer() && $user->enabled == 0) {
            $response->add('message', __('api.lawyer_not_enable'));
            $response->add('enabled', $user->enabled);
        }

        $user->access_token = 'Bearer ' . $tokenResult->accessToken;

        return $response->get();
    }

    public function me()
    {
        if (auth('users')->user()->isLawyer()) {
            return api(true, 200, __('api.success_login'))
                ->add('lawyer', new UserCollection(auth('users')->user()))
                ->get();
        }
        return api(true, 200, __('api.success'))
            ->add('user', new UserCollection(auth('users')->user()))
            ->get();
    }

    public function register(RegisterRequest $request)
    {

        if (User::query()->where('phone', $request['phone'])->first())
            return api(false, 400, __('api.phone_exist'))->get();

//        $code=Code::query()->where('phone', $request['phone'])
//            ->where('code', $request['code'])
//            ->where('created_at','>',now()->subMinutes(5))
//            ->first();
//
//        if(!$code)
//            return api(false, 400, __('api.code_not_exist'))->get();

        $request['password'] = Hash::make($request['password']);
        $user = User::query()->create($request->except('code'));
        $user->enabled = 1;
        $user->enabled_to = now()->addMonths(3)->toDateString();
        $user->save();
        return api(true, 200, __('api.success'))
            ->get();
    }

    public function send_code(SendCodeRequest $request)
    {
        $code = rand(1000, 9999);
        send_verifcation_code($request['phone'], $code);

        Code::query()->updateOrCreate([
            'phone' => $request['phone'],
        ], [
            'code' => $code,
        ]);
        return api(true, 200, __('api.success'))
            ->add('code', $code)
            ->get();
    }

    public function social_login(SocialLoginRequest $request)
    {

        //$verifiedToken=  Firebase::auth()->parseToken($request['token']);
        // $parsedToken = (new Parser)->parse($bearerToken);
        //$test= Firebase::auth()->signInWithEmailAndPassword($request['email'], $request['password']);
        //  dd($test);

        $verifiedToken = Firebase::auth()->verifyIdToken($request['token'], true);

        $name_arr = explode(' ', $verifiedToken->claims()->get('name'));
        $email = $verifiedToken->claims()->get('email');

        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            $user = User::query()->create([
                'name' => isset($name_arr[0]) ? $name_arr[0] : null,
                'email' => $email,
                'password' => Hash::make('123456'),
                'type' => 'user'
            ]);
        }
        $tokenResult = $user->createToken('users', ['users']);
        $token = $tokenResult->token;
        $token->save();
        $response = api(true, 200, __('api.success_login'))
            ->add('user', new UserCollection($user));


        $user->access_token = 'Bearer ' . $tokenResult->accessToken;

        return $response->get();
    }

    public function guest_login()
    {
        $user = User::query()->where('phone','010')->first();
        $tokenResult = $user->createToken('users', ['users']);
        $token = $tokenResult->token;
        $token->save();
        $response = api(true, 200, __('api.success_login'))
            ->add('user', new UserCollection($user));

        $user->access_token = 'Bearer ' . $tokenResult->accessToken;

        return $response->get();
    }
}

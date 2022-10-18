<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

        if ($user->isLawyer() && $user->enable == 0) {
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


}

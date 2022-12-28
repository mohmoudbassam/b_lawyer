<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(auth('users')->user()->phone == '010'){
            return api(false, 400, __('api.you_are_login_as_guest_account'))->get();
        }
    }
}

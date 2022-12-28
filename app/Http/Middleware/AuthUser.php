<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth('users')->check() && $request->user('users')->tokenCan('users') )
            return $next($request);
        return api(false, 400, __('api.unauthenticated'))->get();
    }
}

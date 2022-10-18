<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LawyerAuth
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
        if (auth('users')->check() && $request->user('users')->tokenCan('users') && $request->user('users')->isLawyer())
            return $next($request);

        return api(false, 400, __('api.unauthenticated'))->get();
    }
}

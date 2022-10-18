<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LawyerEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth('users')->user()->isLawyer() && auth('users')->user()->enabled != 1) {
            return api(false, 400, __('api.lawyer_not_enable'))->get();
        }
        return $next($request);
    }
}

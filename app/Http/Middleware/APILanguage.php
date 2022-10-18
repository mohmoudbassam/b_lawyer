<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APILanguage
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
        app()->setLocale($request->header('Accept-Language') ?? 'en');
        return $next($request);
    }
}

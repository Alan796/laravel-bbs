<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RecordLastActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Auth::user()->last_active_at = now()->toDateTimeString();
        }

        return $next($request);
    }
}

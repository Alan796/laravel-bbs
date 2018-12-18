<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RedirectIfConfined
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/');
        }

        $user = Auth::guard($guard)->user();

        if ($user->isConfined()) {
            return redirect()->route('users.show', $user->id)->with('danger', '你已被禁言，不能发帖、评论');
        }

        return $next($request);
    }
}

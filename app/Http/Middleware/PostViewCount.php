<?php

namespace App\Http\Middleware;

use Closure;

class PostViewCount
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
        ++$request->post->view_count;

        return $next($request);
    }
}

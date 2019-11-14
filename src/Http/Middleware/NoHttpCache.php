<?php

namespace Wingsline\Blog\Http\Middleware;

use Closure;

class NoHttpCache
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        $response->header(
            'Cache-Control',
            'no-cache, must-revalidate, no-store, max-age=0, private'
        );

        return $response;
    }
}

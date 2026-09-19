<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceHttps
{
    /**
     * Redirect plain-http requests to https when app.force_https is on.
     *
     * The health check is exempt: load balancers usually probe it over http.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.force_https') && ! $request->secure() && ! $request->is('up')) {
            // 308 keeps the method and body of non-GET requests; 301 is enough for GET/HEAD.
            return redirect()->secure($request->getRequestUri(), $request->isMethodSafe() ? 301 : 308);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Traits\RestApiResponse;

define("ALREADY_AUTHENTICATED_CODE", 401);

class RedirectIfAuthenticated
{
    use RestApiResponse;

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
        if (Auth::guard($guard)->check()) {
            return $this->api_error_response('Already authenticated.', ALREADY_AUTHENTICATED_CODE);
        }

        return $next($request);
    }
}

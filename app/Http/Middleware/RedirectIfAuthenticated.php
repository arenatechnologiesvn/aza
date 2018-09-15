<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Traits\RestApiResponse;

define("ALREADY_AUTHENTICATED_CODE", 403);

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
            return $this->api_error_response(
                AUTH_ALREADY_LOGIN_ERROR_MESSAGE,
                AUTH_ALREADY_LOGIN_ERROR_MESSAGE,
                ALREADY_AUTHENTICATED_CODE
            );
        }

        return $next($request);
    }
}

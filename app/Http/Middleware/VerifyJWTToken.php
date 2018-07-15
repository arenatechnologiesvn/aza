<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Traits\RestApiResponse;

define("TOKEN_ABSENT_CODE", 4000);
define("TOKEN_EXPIRED_CODE", 4001);
define("TOKEN_INVALID_CODE", 4003);
define("USER_NOT_FOUND", 4004);

class VerifyJWTToken
{
    use RestApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->api_error_response('user_not_found', USER_NOT_FOUND);
            }
        } catch (JWTException $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
                return $this->api_error_response('token_expired', TOKEN_EXPIRED_CODE);

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
                return $this->api_error_response('token_invalid', TOKEN_INVALID_CODE);

            return $this->api_error_response('token_absent', TOKEN_ABSENT_CODE);
        }

        return $next($request);
    }
}

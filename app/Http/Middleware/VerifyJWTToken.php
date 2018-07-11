<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Traits\RestApiResponse;

define("TOKEN_EXPIRED_CODE", 401);
define("TOKEN_INVALID_CODE", 402);
define("TOKEN_ABSENT_CODE", 403);
define("USER_NOT_FOUND", 404);

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
                $this->api_error_response('user_not_found', USER_NOT_FOUND);
            }
        } catch (JWTException $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->api_error_response('token_expired', TOKEN_EXPIRED_CODE);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->api_error_response('token_invalid', TOKEN_INVALID_CODE);
            } else {
                return $this->api_error_response('token_absent', TOKEN_ABSENT_CODE);
            }
        }

        return $next($request);
    }
}

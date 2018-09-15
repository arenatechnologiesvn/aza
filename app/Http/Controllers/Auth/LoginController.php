<?php

namespace App\Http\Controllers\Auth;

use App\Customer;
use App\UserAccessHistories;
use App\Helper\RoleConstant;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request)
    {
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($token = $this->attemptLogin($request)) {
            $user = Auth::user();

            if (!$this->isVerified($user)) {
                return $this->api_error_response(
                    AUTH_ACCOUNT_VERIFY_ERROR_MESSAGE,
                    AUTH_ACCOUNT_VERIFY_ERROR_MESSAGE,
                    401
                );
            }

            if ($this->isLocked($user)) {
                return $this->api_error_response(
                    AUTH_ACCOUNT_LOCK_ERROR_MESSAGE,
                    AUTH_ACCOUNT_LOCK_ERROR_MESSAGE,
                    401
                );
            }

            $this->setToken($token);
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->api_error_response(AUTH_LOGIN_ERROR_MESSAGE, AUTH_LOGIN_ERROR_MESSAGE, 401);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt($this->credentials($request));
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $token = (string)$this->guard()->getToken();
        $expiration = $this->guard()->getPayload()->get('exp');

        return $this->api_success_response([
            'data' => [
                'token' => $token,
                'user' => $this->infoUser(),
                'token_type' => 'bearer',
                'expires_in' => $expiration - time()
            ]
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        return $this->api_success_response();
    }

    /**
     * Set token after login successful.
     *
     * @param  String $token
     */
    private function setToken($token)
    {
        $this->guard()->setToken($token);
    }

    private function isVerified($user)
    {
        return $user->is_verified;
    }

    private function isLocked($user)
    {
        return !$user->is_active;
    }

    private function infoUser()
    {
        $user = Auth::user();
        if($user->role_id == RoleConstant::Customer) {
            $this->createAccessLog($user->id);
            $customer = Customer::where('user_id', $user->id)->firstOrFail();
            $user['customer'] = $customer;
        }
        return $user;
    }

    private function createAccessLog($user_id)
    {
        try {
            \DB::beginTransaction();
            UserAccessHistories::create([ 'user_id' => $user_id ]);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }
}

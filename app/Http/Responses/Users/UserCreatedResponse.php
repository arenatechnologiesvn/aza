<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/15/2018
 * Time: 10:01 PM
 */

namespace App\Http\Responses\Users;


use App\User;
use Illuminate\Contracts\Support\Responsable;

class UserCreatedResponse implements Responsable
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json($this->user, 200);
    }
}

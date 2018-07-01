<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/28/2018
 * Time: 12:47 AM
 */

namespace App\Http\Responses\Roles;


use Illuminate\Contracts\Support\Responsable;

class RoleDeleteResponse implements Responsable
{
    protected $role;
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        // TODO: Implement toResponse() method.
        return response()->json(['data' => $this->role->id], 200);

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/23/2018
 * Time: 11:11 AM
 */

namespace App\Http\Responses\Roles;


use Illuminate\Contracts\Support\Responsable;

class RoleEditResponse implements Responsable
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
        return response()->json(['data' => $this->convertToDto()], 200);
    }


    private function convertToDto() {
        return [
            'id' => $this->role->id,
            'title' => $this->role->title,
            'description' => $this->role->description,
            'is_employee' => $this->role->is_employee
        ];
    }
}
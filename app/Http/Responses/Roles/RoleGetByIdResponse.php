<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/27/2018
 * Time: 9:43 PM
 */

namespace App\Http\Responses\Roles;


use Illuminate\Contracts\Support\Responsable;
use PhpParser\Node\Expr\Cast\Object_;

class RoleGetByIdResponse implements Responsable
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
        return response()->json(['data' => $this->toDto()], 200);
    }
    private function toDto() {
        return [
            'id' => $this->role->id,
            'title' => $this->role->title,
            'description' => $this->role->description,
            'is_employee' => (bool) $this->role->is_employee
        ];
    }
}
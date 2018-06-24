<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\RoleCreateRequest;
use App\Http\Requests\Roles\RoleUpdateRequest;
use App\Http\Responses\Roles\RoleEditResponse;
use App\Http\Responses\Roles\RoleIndexResponse;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $role;
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return new RoleIndexResponse($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        //
        $role = $this->role->create($request->all());
        return $role ?
            new RoleEditResponse($role) :
            new FailedResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        return new RoleEditResponse($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        //
//        $permissions = $request->get('permissions');
//        $role = Role::with('permissions')->find($id);
//        unset($request['permissions']);
//        $role->update($request->all());
//        $permissions && $role->permissions()->sync($permissions);
//        return Role::with('permissions')->find($id);
        $role = $this->role->find($id);
        $role->update($request->all());
        return $role ?
            new RoleEditResponse($role) :
            new FailedResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

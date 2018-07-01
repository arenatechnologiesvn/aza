<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\RoleCreateRequest;
use App\Http\Requests\Roles\RoleUpdateRequest;
use App\Http\Responses\FailedResponse;
use App\Http\Responses\Roles\RoleDeleteResponse;
use App\Http\Responses\Roles\RoleEditResponse;
use App\Http\Responses\Roles\RoleGetByIdResponse;
use App\Http\Responses\Roles\RoleIndexResponse;
use App\Role;
use App\User;
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
        $roles = $this->role->get();
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
        return new RoleGetByIdResponse($role);
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
        $this->role->find($id)->delete();
        $roleDeleted = $this->role->onlyTrashed()->find($id);
        return $roleDeleted ? new RoleDeleteResponse($roleDeleted) : new FailedResponse();
    }

    public function deletes(){
        $this->role->whereIn('id', request()->all())->delete();
        return response()->json(['data'=>request()->all()], 200);
    }
}

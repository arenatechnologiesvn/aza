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
use App\Service\RoleService;
use App\User;
use Illuminate\Http\Request;

class RoleController extends CrudController
{
    public function __construct(Role $role, RoleService $service)
    {
        $this->model = $role;
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        return $this->save($request->all());
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
      return $this->edit($request->all(), $id);
    }

    public function deletes(){
        $this->model->whereIn('id', request()->all())->delete();
        return response()->json(['data'=>request()->all()], 200);
    }
}

<?php

namespace App\Http\Controllers;


use App\Http\Requests\Permission\PermissionCreateRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Permission;
use App\Service\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends CrudController
{

    public function __construct(Permission $permission, PermissionService $service)
    {
        $this->model = $permission;
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateRequest $request)
    {
       return $this->save($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        return $this->edit($request->all(), $id);
    }

    public function getByRole(){
        $this->returnData = $this->service->getByRole('');
        return $this->responseApi();
    }
}

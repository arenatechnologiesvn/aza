<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Http\Requests\Employees\StoreEmployeeCreate;
use App\Http\Requests\Employees\StoreEmployeeUpdate;
use App\Service\EmployeeService;

class EmployeeController extends CrudController
{

    public function __construct(Employee $employee, EmployeeService $service)
    {
        $this->model = $employee;
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEmployeeCreate  $request
     * @return
     */
    public function store(StoreEmployeeCreate $request)
    {
        return $this->save($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreEmployeeUpdate  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEmployeeUpdate $request, $id)
    {
        return $this->edit($request->all(), $id);
    }
}

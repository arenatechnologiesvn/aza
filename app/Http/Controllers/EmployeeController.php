<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\Employees\EmployeeCreateRequest;
use App\Http\Responses\Employees\EmployeeCreateResponse;
use App\Http\Responses\Employees\EmployeeIndexResponse;
use App\Http\Responses\Employees\EmployeeUpdateResponse;
use App\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Display a listing of the resource.
     *
     * @return EmployeeIndexResponse
     */
    public function index()
    {
        //
        return new EmployeeIndexResponse();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return EmployeeCreateResponse
     */
    public function store(EmployeeCreateRequest $request)
    {
        return new EmployeeCreateResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $employee = $this->employee->find($id);
        $employee->user->update($request->all());
        return new EmployeeUpdateResponse($employee);
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
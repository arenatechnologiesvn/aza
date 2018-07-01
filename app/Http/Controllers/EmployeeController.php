<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\Employees\EmployeeCreateRequest;
use App\Http\Responses\Employees\EmployeeCreateResponse;
use App\Http\Responses\Employees\EmployeeDeleteByIdResponse;
use App\Http\Responses\Employees\EmployeeGetByIdResponse;
use App\Http\Responses\Employees\EmployeeIndexResponse;
use App\Http\Responses\Employees\EmployeeUpdateResponse;
use App\Http\Responses\FailedResponse;
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
        $employee = $this->employee->find($id);
        return $employee ? new EmployeeGetByIdResponse($employee)
            : new FailedResponse(404, "File not found");
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
        $data = $request->all();
        unset($data['password']);
        if (isset($data['start_datetime'])) {
            $data['start_datetime'] = strtotime($data['start_datetime']);
        }
        $employee = $this->employee->find($id);
        $employee->update($data);
        $employee->user->update($data);
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
        $this->employee->find($id)->delete();
        $employeeDeleted = $this->employee->onlyTrashed()->find($id);
        return $employeeDeleted ? new EmployeeDeleteByIdResponse($employeeDeleted) : new FailedResponse();
    }
}

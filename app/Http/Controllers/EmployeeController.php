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
use App\Service\EmployeeService;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @param  \Illuminate\Http\Request $request
     * @return
     */
    public function store(EmployeeCreateRequest $request)
    {
        return $this->save($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->all();
        return $this->edit($data, $id);
    }

    public function profile()
    {
        $user_id = Auth::user()->id;
        try {
            $profile = $this->model->with(['user' => function ($q) {
                $q->with('userDetail');
            }])->where('user_id', '=', $user_id)->firstOrFail();
            return $this->api_success_response(['data' => $profile]);
        } catch (\Exception $e) {
            return $this->api_error_response(['data' => $e]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
}

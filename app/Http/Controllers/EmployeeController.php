<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\Employees\StoreEmployeeCreate;
use App\Http\Requests\Employees\StoreEmployeeUpdate;
use App\Service\EmployeeService;
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

     * @param  StoreEmployeeCreate  $request

     * @param  \Illuminate\Http\Request $request

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

     * @param  \Illuminate\Http\Request $request
     * @param  int $id

     * @return \Illuminate\Http\Response
     */
    public function update(StoreEmployeeUpdate $request, $id)
    {
        return $this->edit($request->all(), $id);
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

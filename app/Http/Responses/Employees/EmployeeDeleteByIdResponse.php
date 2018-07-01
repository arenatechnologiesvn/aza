<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/1/2018
 * Time: 6:35 AM
 */

namespace App\Http\Responses\Employees;


use App\Helper\ApiResponse;
use Illuminate\Contracts\Support\Responsable;

class EmployeeDeleteByIdResponse implements Responsable
{
    protected $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
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
        return response()->json(new ApiResponse('Delete Employee Successful', ['id' => $this->employee->id], 200 ));
    }
}
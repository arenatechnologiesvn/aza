<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/1/2018
 * Time: 3:19 AM
 */

namespace App\Http\Responses\Employees;


use App\Dto\EmployeeDto;
use App\Helper\ApiResponse;
use Illuminate\Contracts\Support\Responsable;

class EmployeeGetByIdResponse implements Responsable
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
        return response()->json(new ApiResponse('Get Successful Employee by id', EmployeeDto::toDto($this->employee), 200));
    }
}
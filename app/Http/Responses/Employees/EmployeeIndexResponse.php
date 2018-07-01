<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/24/2018
 * Time: 3:11 AM
 */

namespace App\Http\Responses\Employees;


use App\Dto\EmployeeDto;
use App\Employee;
use App\Helper\ApiResponse;
use Illuminate\Contracts\Support\Responsable;

class EmployeeIndexResponse implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json(new ApiResponse('Get Employees successful', $this->toDto(), 200));
        // TODO: Implement toResponse() method.
    }

    private function toDto() {
        return EmployeeDto::toListDto(Employee::all());
    }
}
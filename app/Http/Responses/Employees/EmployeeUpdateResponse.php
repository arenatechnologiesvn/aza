<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/30/2018
 * Time: 8:30 PM
 */

namespace App\Http\Responses\Employees;


use App\Helper\ApiResponse;
use Illuminate\Contracts\Support\Responsable;

class EmployeeUpdateResponse implements Responsable
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
        return response()->json(new ApiResponse('Update Employee Successful', $this->toDto(), 200));
        // TODO: Implement toResponse() method.
    }
    public function toDto(){
        return [
            'id' => $this->employee->id,
            'code' => $this->employee->code,
            'email' => $this->employee->user->email,
            'name' => $this->employee->user->name,
            'role_name' => $this->employee->user->role->description,
            'role_id' => $this->employee->user->role->id,
            'avatar' => $this->employee->user->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower($this->employee->user->email)) . '.jpg?s=200&d=mm',
            'start_datetime' => date('Y-m-d H:i:s', $this->employee->start_datetime),
            'phone' => $this->employee->user->phone,
            'full_name' => $this->employee->user->first_name . ' ' . $this->employee->user->last_name,
            'first_name' => $this->employee->user->first_name,
            'last_name' => $this->employee->user->last_name,
            'is_active' => (bool) $this->employee->user->is_active,
            'customer_count' => count($this->employee->customers)
        ];
    }
}
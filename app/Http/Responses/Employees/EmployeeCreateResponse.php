<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/24/2018
 * Time: 12:24 AM
 */

namespace App\Http\Responses\Employees;


use App\Employee;
use App\Helper\ApiResponse;
use App\Http\Responses\FailedResponse;
use App\User;
use Illuminate\Contracts\Support\Responsable;

class EmployeeCreateResponse implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        try {
            $employee = $this->saveEmployee($request->all());
            return  $employee ? response()->json(new ApiResponse('Create Employee successful', $employee, 200)) : new FailedResponse();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        // TODO: Implement toResponse() method.
    }

    private function saveEmployee(array $data) {
        try {
            $user = User::create([
                'name' => $data['name'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'password' => bcrypt($data['password']),
                'phone' => $data['phone'],
                'is_active' => $data['is_active']
            ]);
            if ($user) {
                return Employee::create([
                    'user_id' => $user->id,
                    'code' => $data['code'],
                    'start_datetime' => strtotime($data['start_datetime'])
                ]);
            } else {
                return false;
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
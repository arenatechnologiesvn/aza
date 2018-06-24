<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/24/2018
 * Time: 3:11 AM
 */

namespace App\Http\Responses\Employees;


use App\Employee;
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
        return response()->json($this->toDto(), 200);
        // TODO: Implement toResponse() method.

    }

    private function toDto() {
        return Employee::all()->map(function($item) {
            return [
                'id' => $item->id,
                'code' => $item->code,
                'email' => $item->user->email,
                'name' => $item->user->name,
                'role_name' => $item->user->role->description,
                'role_id' => $item->user->role->id,
                'avatar' => $item->user->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower($item->user->email)) . '.jpg?s=200&d=mm',
                'start_datetime' => date('Y-m-d H:i:s', $item->start_datetime),
                'phone' => $item->user->phone,
                'full_name' => $item->user->first_name . ' ' . $item->user->last_name,
                'first_name' => $item->user->first_name,
                'last_name' => $item->user->last_name
            ];
        });
    }
}
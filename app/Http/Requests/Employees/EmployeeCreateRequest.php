<?php

namespace App\Http\Requests\Employees;

use App\Http\Requests\BaseFormRequest;

class EmployeeCreateRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'name' => 'required|string|max:100|unique:users',
//            'email' => 'required|string|email|max:255|unique:users',
//            'role_id' => 'required|exists:roles,id',
//            'password' => 'required|string|min:6',
//            'phone' => 'required|string|unique:users',
            'code' => 'required|string|max:20|unique:employees',
        ];
    }
}

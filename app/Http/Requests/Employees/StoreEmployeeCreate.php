<?php

namespace App\Http\Requests\Employees;

use App\Http\Requests\BaseFormRequest;

class StoreEmployeeCreate extends BaseFormRequest
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
            'code' => 'required|string|max:20|unique:employees',
            'user.name' => 'required|string|max:255|unique:users,name',
            'user.email' => 'required|string|email|max:255|unique:users,email',
            'user.avatar' => 'nullable|numeric|exists:media,id',
            'user.first_name' => 'nullable|string|max:50',
            'user.last_name' => 'nullable|string|max:50',
            'user.phone' => 'required|string|max:20',
            'user.address' => 'nullable|string|max:255',
            'user.role_id' => 'required|numeric|exists:roles,id',
            'user.is_active' => 'nullable|boolean',
            'contract_at' => 'nullable|date_format:d-m-Y'
        ];
    }
}

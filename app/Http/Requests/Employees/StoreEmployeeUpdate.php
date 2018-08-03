<?php

namespace App\Http\Requests\Employees;

use App\Http\Requests\BaseFormRequest;
use App\Employee;

class StoreEmployeeUpdate extends BaseFormRequest
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
        $employee = Employee::find($this->employee);
        return [
            'code' => 'required|string|max:20|unique:employees,code,' . $employee->id,
            'avatar' => 'nullable|numeric|exists:media,id',
            'user.first_name' => 'nullable|string|max:50',
            'user.last_name' => 'nullable|string|max:50',
            'user.phone' => 'nullable|string|max:20',
            'user.address' => 'nullable|string|max:255',
            'user.role_id' => 'nullable|numeric|exists:roles,id',
            'user.is_active' => 'nullable|boolean',
            'contract_at' => 'nullable|date_format:d-m-Y'
        ];
    }
}

<?php

namespace App\Http\Requests\Customers;

use App\Http\Requests\BaseFormRequest;

class StoreCustomerCreate extends BaseFormRequest
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
            'code' => 'required|string|max:20|unique:customers,code',
            'customer_type' => 'required|boolean',
            'employee_id' => 'required|numeric|exists:employees,id',
            'zone' => 'nullable|string|max:255',
            'province_code' => 'nullable|numeric|min:0',
            'district_code' => 'nullable|numeric|min:0',
            'ward_code' => 'nullable|numeric|min:0',
            'shops'=> 'nullable|array',
            'avatar' => 'nullable|numeric|exists:media,id',
            'user.name' => 'required|string|max:100|unique:users,name',
            'user.email' => 'required|string|email|max:255|unique:users,email',
            'user.first_name' => 'nullable|string|max:50',
            'user.last_name' => 'nullable|string|max:50',
            'user.phone' => 'nullable|string|max:20',
            'user.address' => 'nullable|string|max:255',
            'user.is_active' => 'nullable|boolean',
            'user.is_verified' => 'nullable|boolean',
            'user.role_id' => 'required|numeric|exists:roles,id'
        ];
    }
}

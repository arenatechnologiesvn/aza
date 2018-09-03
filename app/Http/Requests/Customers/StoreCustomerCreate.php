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
            'user.phone' => 'required|string|max:20',
            'user.address' => 'nullable|string|max:255',
            'user.is_verified' => 'nullable|boolean',
            'user.role_id' => 'required|numeric|exists:roles,id'
        ];
    }

    public function messages()
    {
        return [
            'code.max' => 'Mã khách hàng phải nhỏ hơn 20 ký tự.',
            'code.unique' => 'Mã khách hàng đã được đăng ký.',
            'user.name.max' => 'Tên đăng nhập phải nhỏ hơn 100 ký tự.',
            'user.name.unique' => 'Tên đăng nhập đã được đăng ký.',
            'user.email.max' => 'Email phải nhỏ hơn 255 ký tự.',
            'user.email.email' => 'Email không đúng.',
            'user.email.unique' => 'Email đã được đăng ký.',
            'user.first_name.max' => 'Tên khách hàng phải nhỏ hơn 100 ký tự.',
            'user.last_name.max' => 'Tên khách hàng phải nhỏ hơn 100 ký tự.',
            'user.phone.max' => 'Số điện thoại phải nhỏ hơn 20 ký tự.',
            'user.address.max' => 'Địa chỉ phải nhỏ hơn 255 ký tự.'
        ];
    }
}

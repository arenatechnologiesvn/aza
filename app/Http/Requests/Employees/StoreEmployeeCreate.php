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
            'code' => 'required|string|max:20|unique:employees,code',
            'avatar' => 'nullable|numeric|exists:media,id',
            'user.name' => 'required|string|max:255|unique:users,name',
            'user.email' => 'required|string|email|max:255|unique:users,email',
            'user.first_name' => 'nullable|string|max:50',
            'user.last_name' => 'nullable|string|max:50',
            'user.phone' => 'required|string|max:20',
            'user.address' => 'nullable|string|max:255',
            'user.role_id' => 'required|numeric|exists:roles,id',
            'user.is_active' => 'nullable|boolean',
            'contract_at' => 'nullable|date_format:d-m-Y'
        ];
    }

    public function messages()
    {
        return [
            'code.max' => 'Mã nhân viên phải nhỏ hơn 20 ký tự.',
            'code.unique' => 'Mã nhân viên đã được đăng ký.',
            'user.name.max' => 'Tên đăng nhập phải nhỏ hơn 100 ký tự.',
            'user.name.unique' => 'Tên đăng nhập đã được đăng ký.',
            'user.email.max' => 'Email phải nhỏ hơn 255 ký tự.',
            'user.email.email' => 'Email không đúng.',
            'user.email.unique' => 'Email đã được đăng ký.',
            'user.first_name.max' => 'Tên nhân viên phải nhỏ hơn 100 ký tự.',
            'user.last_name.max' => 'Tên nhân viên phải nhỏ hơn 100 ký tự.',
            'user.phone.max' => 'Số điện thoại phải nhỏ hơn 20 ký tự.',
            'user.address.max' => 'Địa chỉ phải nhỏ hơn 255 ký tự.'
        ];
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/17/2018
 * Time: 9:29 PM
 */

namespace App\Http\Requests\User;


use App\Http\Requests\BaseFormRequest;

class UpdateUserFormRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // TODO: Implement rules() method.
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'user_detail.birthday'=>'required|date',
            'user_detail.sex' => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO: Implement authorize() method.
        return true;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Tên người dùng là bắt buộc',
            'last_name.required' => 'Họ người dùng là bắt buộc',
            'first_name.max' => 'Tên khách hàng phải nhỏ hơn 50 ký tự.',
            'last_name.max' => 'Tên khách hàng phải nhỏ hơn 50 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.max' => 'Số điện thoại không được quá 20 ký tự',
            'address.nullable' => 'Địa chỉ là không bắt buộc',
            'address.max' => 'Địa chỉ không được quá 255 ký tự',
            'user_detail.birthday.required' => 'Ngày sinh là bắt buộc',
            'user_detail.birthday.date' => 'Ngày sinh phải là có định dạng Ngày-Tháng-Năm',
            'user_detail.sex' => 'Giới tính là bắt buộc'
        ];
    }
}
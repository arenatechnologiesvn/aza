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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|max:11',
            'address' => 'nullable|max:255',
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
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.max' => 'Số điện thoại không quá 11 ký tự',
            'address.nullable' => 'Địa chỉ là không bắt buộc',
            'user_detail.birthday.required' => 'Ngày sinh là bắt buộc',
            'user_detail.birthday.date' => 'Ngày sinh phải là có định dạng Tháng/Ngày/Năm',
            'user_detail.sex' => 'Giới tính là bắt buộc'
        ];
    }
}
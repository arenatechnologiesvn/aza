<?php

namespace App\Http\Requests\Customers;

use App\Http\Requests\BaseFormRequest;

class StoreCustomerBulkCreate extends BaseFormRequest
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
            '*.code' => 'required|string|max:20|unique:customers,code',
            '*.customer_type' => 'required|boolean',
            '*.employee_code' => 'required|string|exists:employees,code|is_active_employee|is_sale_employee',
            '*.user.name' => 'required|string|max:100|unique:users,name',
            '*.user.email' => 'required|string|email|max:255|unique:users,email',
            '*.user.first_name' => 'nullable|string|max:50',
            '*.user.last_name' => 'nullable|string|max:50',
            '*.user.phone' => 'nullable|string|max:20',
            '*.user.address' => 'nullable|string|max:255'
        ];
    }

    public function messages()
    {
        $messages = [];
        foreach ($this->request->all() as $key => $data) {
            $messages[$key . '.code.max'] = 'Hàng #' . ($key + 1) .': Mã khách hàng phải nhỏ hơn 20 ký tự.';
            $messages[$key . '.code.unique'] = 'Hàng #' . ($key + 1) .': Mã khách hàng '. $data['code'] . ' đã được đăng ký.';
            $messages[$key . '.customer_type.required'] = 'Hàng #' . ($key + 1) .': Loại khách hàng không được trống.';
            $messages[$key . '.employee_code.exists'] = 'Hàng #' . ($key + 1) . ': Mã nhân viên '. $data['employee_code'] .' không tồn tại.';
            $messages[$key . '.employee_code.is_sale_employee'] = 'Hàng #' . ($key + 1) . ': Mã nhân viên '. $data['employee_code'] .' không phải là nhân viên SALE.';
            $messages[$key . '.employee_code.is_active_employee'] = 'Hàng #' . ($key + 1) . ': Mã nhân viên '. $data['employee_code'] .' chưa được hoạt động.';
            $messages[$key . '.user.name.max'] = 'Hàng #' . ($key + 1) . ': Tên đăng nhập phải nhỏ hơn 100 ký tự.';
            $messages[$key . '.user.name.unique'] = 'Hàng #' . ($key + 1) . ': Tên đăng nhập ' . $data['user']['name'] . ' đã được đăng ký.';
            $messages[$key . '.user.email.max'] = 'Hàng #' . ($key + 1) . ': Email phải nhỏ hơn 255 ký tự.';
            $messages[$key . '.user.email.email'] = 'Hàng #' . ($key + 1) . ': Email không đúng.';
            $messages[$key . '.user.email.unique'] = 'Hàng #' . ($key + 1) . ': Email ' . $data['user']['email'] . ' đã được đăng ký.';
            $messages[$key . '.user.first_name.max'] = 'Hàng #' . ($key + 1) . ': Tên khách hàng phải nhỏ hơn 100 ký tự.';
            $messages[$key . '.user.last_name.max'] = 'Hàng #' . ($key + 1) . ': Tên khách hàng phải nhỏ hơn 100 ký tự.';
            $messages[$key . '.user.phone.max'] = 'Hàng #' . ($key + 1) . ': Số điện thoại phải nhỏ hơn 20 ký tự.';
            $messages[$key . '.user.address.max'] = 'Hàng #' . ($key + 1) . ': Địa chỉ phải nhỏ hơn 255 ký tự.';
        }
        return $messages;
    }
}

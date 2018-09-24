<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/17/2018
 * Time: 9:08 PM
 */

namespace App\Http\Requests\Carts;

use App\Http\Requests\BaseFormRequest;

class UpdateCartFormRequest extends BaseFormRequest
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
            'customer_id' => 'required|numeric|exists:customers,id',
            'product_id' => 'required|numeric|exists:products,id',
            'quantity' => 'required|numeric|min:0'
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
            'customer_id.required' => 'Mã khách hàng là bắt buộc',
            'customer_id.numeric' => 'Mã khách hàng phải là số',
            'customer_id.exists' => 'Mã khách hàng không tồn tại',
            'product_id.required' => 'Mã sản phẩm là bắt buộc',
            'product_id.numeric' => 'Mã sản phẩm phải là số',
            'product_id.exists' => 'Mã sản phẩm không tồn tại',
            'quantity.required' => 'Số lượng sản phẩm là bắt buộc',
            'quantity.numeric' => 'Số lượng sản phẩm phải là số',
            'quantity.min' => 'Số lượng sản phẩm phải lớn hơn 0'
        ];
    }
}


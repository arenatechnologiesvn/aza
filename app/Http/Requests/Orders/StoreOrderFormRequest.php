<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/17/2018
 * Time: 10:08 PM
 */

namespace App\Http\Requests\Orders;


use App\Http\Requests\BaseFormRequest;

class StoreOrderFormRequest extends BaseFormRequest
{
    public function rules()
    {
        // TODO: Implement rules() method.
        return [
            'delivery_address' => 'required',
            'delivery' => 'required|date',
            'customer_id' => 'required|numeric|exists:customers,id',
            'delivery_type' => 'required',
            'discount'=> 'nullable|numeric',
            'description' => 'nullable',
            'shop_id' => 'required|numeric|exists:shops,id',
            'title' => 'nullable',
            'product.*.product_id'=> 'required|numeric|exists:products,id',
            'product.*.quantity'=> 'required|numeric|min:0',
            'product.*.tmp_price'=> 'required|numeric',
            'product.*.real_price'=> 'required|numeric'
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
            'delivery_address.required' => 'Địa chỉ nhận hàng là bắt buộc',
            'delivery.required' => 'Ngày giao hàng là bắt buộc',
            'delivery.date' => 'Ngày giao hàng chưa đúng định dạng',
            'customer_id.required' => 'Mã khách hàng là bắt buộc',
            'customer_id.exists' => 'Mã khách hàng không tồn tại',
            'delivery_type.required' => 'Giờ giao hàng là bắt buộc',
            'shop_id.required' => 'Mã cửa hàng là bắt buộc',
            'shop_id.exists' => 'Cửa hàng không tồn tại',
            'product.*.product_id.required' => 'Mã sản phẩm là bắt buộc',
            'product.*.product_id.numeric' => 'Mã sản phẩm phải là số',
            'product.*.product_id.exists' => 'Sản phẩm không tồn tại',
            'product.*.quantity.required' => 'Số lượng sản phẩm là bắt buộc',
            'product.*.quantity.numeric' => 'Số lượng sản phẩm phải là số',
            'product.*.tmp_price.required' => 'Giá tạm sản phẩm là bắt buộc',
            'product.*.tmp_price.numeric' => 'Giá tạm sản phẩm phải là số',
            'product.*.real_price.required' => 'Giá thực tế sản phẩm là bắt buộc',
            'product.*.real_price.numeric' => 'Giá thực tế sản phẩm phải là số',
        ];
    }
}
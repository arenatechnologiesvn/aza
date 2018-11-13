<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/17/2018
 * Time: 9:11 PM
 */
namespace App\Http\Requests\Carts;

use App\Http\Requests\BaseFormRequest;

class BulkStoreCartFormRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '*.product_id' => 'required|numeric|exists:products,id'
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            '*.product_id.required' => 'Mã sản phẩm là bắt buộc',
            '*.product_id.numeric' => 'Mã sản phẩm phải là số',
            '*.product_id.exists' => 'Mã sản phẩm không tồn tại'
        ];
    }
}

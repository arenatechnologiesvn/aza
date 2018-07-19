<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseFormRequest;

class StoreProduct extends BaseFormRequest
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
            'product_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:255',
            'preview_images'=> 'nullable|array',
            'featured_image'=> 'nullable|numeric|exists:media,id',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'provider_id' => 'nullable|numeric|exists:providers,id',
            'description'=> 'nullable|string|max:500'
        ];
    }
}

<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|unique:products|max:255',
            'name' => 'required|string|max:255',
            'price' => 'required|numberic',
            'discountPrice' => 'numberic',
            'unit' => 'required|numberic',
            'imageUrl'=> 'required|string|max:500',
            'categoryId' => 'required|exists:categories,id',
            'providerId' => 'required|exists:companies,id',
            'description'=> 'string|max:500',
        ];
    }
}

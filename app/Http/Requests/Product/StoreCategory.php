<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseFormRequest;

class StoreCategory extends BaseFormRequest
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
            'code' => 'required|max:255',
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'description'=> 'nullable|string|max:500'
        ];
    }
}

<?php

namespace App\Http\Requests\Shops;

use App\Http\Requests\BaseFormRequest;

class StoreShop extends BaseFormRequest
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
            'customer_id' => 'required|numeric|exists:customers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'zone' => 'required|string|max:255',
            'province_code' => 'required|numeric|min:0',
            'district_code' => 'required|numeric|min:0',
            'ward_code' => 'required|numeric|min:0',
        ];
    }
}

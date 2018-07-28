<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseFormRequest;

class StoreProvider extends BaseFormRequest
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
            'code' => 'required|max:50',
            'name' => 'required|string|max:100',
            'logo'=> 'nullable|numeric|exists:media,id',
            'description' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'home_phone' => 'nullable|string|max:15',
            'zone' => 'nullable|string|max:255',
            'province_code' => 'nullable|numeric|min:0',
            'district_code' => 'nullable|numeric|min:0',
            'ward_code' => 'nullable|numeric|min:0',
            'contract_at' => 'nullable|date_format:d-m-Y'
        ];
    }
}

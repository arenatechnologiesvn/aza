<?php

namespace App\Http\Requests\Report;

use App\Http\Requests\BaseFormRequest;

class StoreRevenue extends BaseFormRequest
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
            'type' => 'required|string|in:month,year',
            'month' => 'required_if:type,==,month|date_format:m-Y',
            'year' => 'required_if:type,==,year|date_format:Y'
        ];
    }
}

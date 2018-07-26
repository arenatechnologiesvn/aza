<?php

namespace App\Http\Requests\Report;

use App\Http\Requests\BaseFormRequest;

class StoreEmployeeRevenue extends BaseFormRequest
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
            'employee_id' => 'required|numeric|exists:employees,id',
            'start_date' => 'required|date_format:d-m-Y|before:end_date',
            'end_date' => 'required|date_format:d-m-Y|before:tomorrow'
        ];
    }
}

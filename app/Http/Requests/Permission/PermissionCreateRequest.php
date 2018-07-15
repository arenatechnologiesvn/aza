<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\BaseFormRequest;

class PermissionCreateRequest extends BaseFormRequest
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
            'name' => 'required|string|max:255|unique:permissions',
            'title' => 'required|string|max:255|unique:permissions',
            'url_action' => 'required|string',
            'level'=>'required',
            "path" => "required|string"
        ];
    }
}

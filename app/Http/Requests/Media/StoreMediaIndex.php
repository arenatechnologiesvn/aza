<?php

namespace App\Http\Requests\Media;

use App\Http\Requests\BaseFormRequest;

class StoreMediaIndex extends BaseFormRequest
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
            'type' => 'required|string|in:user,shop,product,provider'
        ];
    }
}

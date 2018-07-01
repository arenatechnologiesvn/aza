<?php

namespace App\Http\Requests\User;

use App\Helper\CheckAccess;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Facades\Auth;

class UserCreateRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return CheckAccess::check(Auth::user()->id, 'create-user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|unique:users'
        ];
    }
}

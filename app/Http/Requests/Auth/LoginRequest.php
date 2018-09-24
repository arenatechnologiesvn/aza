<?php

namespace App\Http\Requests\Auth;


use App\Http\Requests\BaseFormRequest;

class LoginRequest extends BaseFormRequest
{
    protected $statusCode = 422;
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được trống.',
            'email.email' => 'Email không đúng.',
            'email.max' => 'Email phải nhỏ hơn 255 ký tự.',
            'password.required' => 'Mật khẩu không được trống.',
            'password.min' => 'Mật khẩu phải lớn hơn 6 ký tự.'
        ];
    }
}

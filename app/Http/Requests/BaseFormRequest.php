<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/15/2018
 * Time: 10:20 AM
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

abstract class BaseFormRequest extends FormRequest
{
    protected $statusCode;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $laravel = app();
        $version = $laravel::VERSION;
        if (substr($version, 0, 3) == '5.4') {
            $errors = $validator->messages()->messages();
        } else {
            $errors = (new ValidationException($validator))->errors();
        }

        $transformed = [];
        foreach ($errors as $field => $message) {
            $transformed[] = [
                'field' => $field,
                'message' => $message[0]
            ];
        }
        if ($this->statusCode == 400) {
            $statusResponse = JsonResponse::HTTP_BAD_REQUEST;
        } else {
            $statusResponse = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        }
        throw new HttpResponseException(response()->json(['errors' => $transformed
        ], $statusResponse));
    }
    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\UnauthorizedException
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json(['errors' => trans('auth.unauthorized')], 401));
        // throw new UnauthorizedException;
    }
}

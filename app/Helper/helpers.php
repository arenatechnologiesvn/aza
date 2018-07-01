<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/15/2018
 * Time: 10:50 AM
 */
if (!function_exists('api_validate')) {
    /**
     * Get the ApiFormRequest instance
     *
     * @return App\Http\Requests\BaseFormRequest
     */
    function api_validate()
    {
        return app(App\Http\Requests\BaseFormRequest::class);
    }
}

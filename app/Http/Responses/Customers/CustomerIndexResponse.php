<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/24/2018
 * Time: 5:18 AM
 */

namespace App\Http\Responses\Customers;


use App\Customer;
use App\Dto\CustomerDto;
use App\Helper\ApiResponse;
use Illuminate\Contracts\Support\Responsable;

class CustomerIndexResponse implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json(new ApiResponse('Get Customer successful', CustomerDto::toListDto(Customer::all()), 200));
        // TODO: Implement toResponse() method.

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/1/2018
 * Time: 8:18 AM
 */

namespace App\Http\Responses\Customers;


use App\Dto\CustomerDto;
use App\Helper\ApiResponse;
use Illuminate\Contracts\Support\Responsable;

class CustomerUpdateResponse implements Responsable
{
    protected $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        // TODO: Implement toResponse() method.
        return response()->json(new ApiResponse('Update customer successful', CustomerDto::toDto($this->customer), 200));
    }
}
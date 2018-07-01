<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/1/2018
 * Time: 9:38 AM
 */

namespace App\Http\Responses\Shops;


use App\Dto\ShopDto;
use App\Helper\ApiResponse;
use Illuminate\Contracts\Support\Responsable;

class ShopGetIndexByIdResponse implements Responsable
{
    protected $shop;

    public function __construct($shop)
    {
        $this->shop = $shop;
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
        return response()->json(new ApiResponse('Get Shop Successful', ShopDto::toDto($this->shop), 200));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/24/2018
 * Time: 5:19 AM
 */

namespace App\Http\Responses\Shops;


use App\Dto\ShopDto;
use App\Helper\ApiResponse;
use App\Shop;
use Illuminate\Contracts\Support\Responsable;

class ShopIndexResponse implements Responsable
{

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        // TODO: Implement toResponse() method.
        return response()->json(new ApiResponse('Get Shops Successful', ShopDto::toListDto(Shop::all()), 200), 200);
    }

}
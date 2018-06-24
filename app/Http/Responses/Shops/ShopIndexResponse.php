<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/24/2018
 * Time: 5:19 AM
 */

namespace App\Http\Responses\Shops;


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
        return response()->json($this->toDto(), 200);
    }

    private function toDto() {
        return Shop::all()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'address' => $item->address,
                'preview_image' => $item->preview_image ?? 'https://www.gravatar.com/avatar/' . md5(strtolower($item->name)) . '.jpg?s=200&d=mm',
                'phone' => $item->phone,
                'home_phone' => $item->home_phone,
                'customer_name' => $item->customer->user->first_name . ' ' . $item->customer->user->last_name,
                'customer_id' => $item->customer->id
            ];
        });
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/24/2018
 * Time: 5:19 AM
 */

namespace App\Http\Responses\Shops;


use App\Http\Responses\FailedResponse;
use App\Shop;
use Illuminate\Contracts\Support\Responsable;

class ShopCreateResponse implements Responsable
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
        try {
            $shop = $this->saveShop($request->all());
            return $shop ? response()->json($shop, 200) : new FailedResponse();
        }catch (\Exception $e) {
            return new FailedResponse();
        }
    }

    private function saveShop(array $data) {
        try {
            return Shop::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'home_phone' => $data['home_phone'],
                'customer_id' => $data['customer_id'],
                'description' => $data['description'],
                'preview_image' => $data['preview_image'],
                'address' => $data['address'],
                'province_code' => $data['selectedProvince']['selectedProvince'],
                'district_code' => $data['selectedProvince']['selectedDistrict'],
                'ward_code' => $data['selectedProvince']['selectedWard']
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
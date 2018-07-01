<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/1/2018
 * Time: 9:06 AM
 */

namespace App\Dto;


class ShopDto implements BaseDto
{

    public static function toDto($item)
    {
        // TODO: Implement toDto() method.
        return [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'address' => $item->address,
            'preview_image' => $item->preview_image ?? 'https://www.gravatar.com/avatar/' . md5(strtolower($item->name)) . '.jpg?s=200&d=mm',
            'phone' => $item->phone,
            'home_phone' => $item->home_phone,
            'customer_name' => $item->customer->user->first_name . ' ' . $item->customer->user->last_name,
            'customer_id' => $item->customer->id,
            'selectedProvince' => [
                'selectedProvince' => $item->province_code,
                'selectedDistrict' => $item->district_code,
                'selectedWard' => $item->ward_code
            ]
        ];
    }

    public static function toListDto($items)
    {
        // TODO: Implement toListDto() method.
        return $items->map(function ($item){
            return ShopDto::toDto($item);
        });
    }
}
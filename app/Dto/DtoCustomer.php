<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/1/2018
 * Time: 6:57 AM
 */

namespace App\Dto;


class DtoCustomer implements Dto
{

    public function toDto($item)
    {
        // TODO: Implement toDto() method.
        return [
            'id' => $item->id,
            'code' => $item->code,
            'email' => $item->user->email,
            'name' => $item->user->name,
            'customer_type' => $item->customer_type,
            'role_id' => $item->user->role->id,
            'is_active' => (bool) $item->user->is_active,
            'avatar' => $item->user->avatar ?? '',
            'phone' => $item->user->phone,
            'full_name' => $item->user->first_name . ' ' . $item->user->last_name,
            'first_name' => $item->user->first_name,
            'last_name' => $item->user->last_name,
            'employee_id' => $item->employee ? $item->employee->id : 0,
            'employee' => $item->employee ? $item->employee->user->first_name . ' ' . $item->employee->user->last_name : '',
            'shop_count' => $item->shops ? count($item->shops) : 0,
            'selectedProvince' => [
                'selectedProvince' => $item->province_code,
                'selectedDistrict' => $item->district_code,
                'selectedWard' => $item->ward_code
            ]
        ];
    }

    public function toListDto($items)
    {
        // TODO: Implement toListDto() method.
        return $items->map(function ($item){
            return CustomerDto::toDto($item);
        });
    }
}
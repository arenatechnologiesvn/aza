<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/1/2018
 * Time: 3:22 AM
 */

namespace App\Dto;


class EmployeeDto implements BaseDto
{
    public static function toDto($item){
        return [
            'id' => $item->id,
            'code' => $item->code,
            'email' => $item->user->email,
            'name' => $item->user->name,
            'role_name' => $item->user->role->description,
            'role_id' => $item->user->role->id,
            'avatar' => $item->user->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower($item->user->email)) . '.jpg?s=200&d=mm',
            'start_datetime' => date('Y-m-d H:i:s', $item->start_datetime),
            'phone' => $item->user->phone,
            'full_name' => $item->user->first_name . ' ' . $item->user->last_name,
            'first_name' => $item->user->first_name,
            'last_name' => $item->user->last_name,
            'is_active' => (bool) $item->user->is_active,
            'customer_count' => count($item->customers)
        ];
    }

    public static function toListDto($items) {
        return $items->map(function ($item){
            return EmployeeDto::toDto($item);
        });
    }
}
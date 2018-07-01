<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/1/2018
 * Time: 10:21 AM
 */

namespace App\Dto;


class UserDto implements BaseDto
{

    public static function toDto($item)
    {
        // TODO: Implement toDto() method.
        return [
            'id' => $item->id,
            'email' => $item->email,
            'name' => $item->name,
            'role' => $item->role,
            'role_description' => $item->role->description,
            'role_name' =>  $item->role->title,
            'avatar' => $item->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower($item->email)) . '.jpg?s=200&d=mm',
            'phone' => $item->phone,
            'full_name' => $item->first_name . ' ' . $item->last_name,
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
        ];
    }

    public static function toListDto($items)
    {
        // TODO: Implement toListDto() method.
    }
}
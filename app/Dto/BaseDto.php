<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/1/2018
 * Time: 6:58 AM
 */

namespace App\Dto;


interface BaseDto
{
    public static function toDto($item);
    public static function toListDto($items);
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/10/2018
 * Time: 1:01 AM
 */

namespace App\Dto;


interface Dto
{
    public function toDto($item);
    public function toListDto($items);
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/30/2018
 * Time: 1:55 PM
 */

namespace App\Helper;


class ApiResponse
{
    public $message;
    public $data;
    public $code;

    public function __construct($message, $data, $code)
    {
        $this->message = $message;
        $this->data = $data;
        $this->code = $code;
    }
}
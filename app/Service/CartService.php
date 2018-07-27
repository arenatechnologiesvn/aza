<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/27/2018
 * Time: 1:15 AM
 */

namespace App\Service;


use App\Order;

class CartService extends BaseService
{
    protected $selectable = [
        'product_id',
        'customer_id',
        'quantity'
    ];

    public function __construct(Order $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

}
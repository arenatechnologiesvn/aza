<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    //
    public $timestamps = false;
    protected $table = 'order_product';
    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'tmp_price',
        'real_price'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    public $timestamps = false;
    protected $table = 'carts';
//    protected $primaryKey = ['product_id', 'customer_id'];
    protected $fillable = [
        'product_id',
        'customer_id',
        'quantity'
    ];
}

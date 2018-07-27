<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
    public $timestamps = false;
    protected $table = 'favorites';
//    protected $primaryKey = ['product_id', 'customer_id'];
    protected $fillable = [
        'product_id',
        'customer_id'
    ];
}

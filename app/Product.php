<?php

namespace App;
use Plank\Mediable\Mediable;

class Product extends BaseModel
{
    use Mediable;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_code',
        'name',
        'description',
        'unit',
        'price',
        'discount_price',
        'category_id',
        'provider_id'
    ];

    public $primaryKey = 'id';

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function orders() {
        return $this->belongsToMany(Order::class,'order_product');
    }
}

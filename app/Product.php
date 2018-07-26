<?php

namespace App;
use Plank\Mediable\Mediable;
use Plank\Mediable\Media as Media;

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
        return $this->belongsToMany(Order::class,'order_product')
                ->withPivot('quantity', 'tmp_price', 'real_price');
    }

    public function customerFavorites () {
        return $this->belongsToMany(Customer::class,'favorites', 'product_id','customer_id');
    }

    public function customerCarts () {
        return $this->belongsToMany(Customer::class,'carts', 'product_id','customer_id');
    }
    public function preview () {
        return $this->morphToMany('Plank\Mediable\Media', 'mediable','mediables', 'mediable_id')
        ->withPivot('mediable_type', 'tag')
        ->where([
            ['mediable_type', '=', 'App\Product'],
            ['tag', '=', 'preview']
        ]);
    }
    public function featureds () {
        return $this->morphToMany('Plank\Mediable\Media', 'mediable','mediables', 'mediable_id')
        ->withPivot('mediable_type', 'tag')
        ->where([
            ['mediable_type', '=', 'App\Product'],
            ['tag', '=', 'featured']
        ]);
    }
}

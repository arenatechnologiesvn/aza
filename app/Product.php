<?php

namespace App;

class Product extends BaseModel
{
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
        'preview_images',
        'featured_images',
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
}

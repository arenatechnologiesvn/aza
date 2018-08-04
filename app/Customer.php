<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends BaseModel
{
    protected $table = 'customers';
    protected $fillable = [
        'code',
        'user_id',
        'status',
        'customer_type',
        'point',
        'employee_id',
        'zone',
        'province_code',
        'district_code',
        'ward_code',
        'favorites',
        'carts',
        'sex'
    ];
    protected $hidden = [
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];
    public static function boot()
    {
        parent::boot();

        static::deleting(function($model)
        {
            $model->user()->delete();
            $model->shops()->delete();
        });
    }
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function shops() {
        return $this->hasMany(Shop::class);
    }
    public function favorites(){
        return $this->belongsToMany(Product::class,'favorites', 'customer_id','product_id');
    }
    public function carts(){
        return $this->belongsToMany(Product::class,'carts', 'customer_id','product_id')
            ->withPivot('quantity');
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
    //
    protected $table = 'orders';
    protected $fillable = [
        'order_code',
        'title',
        'description',
        'approve_employee',
        'approve_note',
        'status',
        'customer_id',
        'apply_at',
        'delivery',
        'delivery_type',
        'delivery_address',
        'total_money'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function products() {
        return $this->belongsToMany(Product::class,'order_product')
                ->withPivot('quantity', 'tmp_price', 'real_price');
    }
}

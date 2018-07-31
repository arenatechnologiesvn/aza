<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends BaseModel
{
    protected $table = 'shops';

    protected $fillable = [
        'name',
        'preview_image',
        'description',
        'address',
        'region',
        'phone',
        'home_phone',
        'province_code',
        'district_code',
        'ward_code',
        'customer_id'
    ];

    protected $hidden = [
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}

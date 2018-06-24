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
        'province_code',
        'district_code',
        'ward_code'
    ];
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function shops() {
        return $this->hasMany(Shop::class);
    }
}

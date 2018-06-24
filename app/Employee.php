<?php

namespace App;


class Employee extends BaseModel
{
    protected $table = 'employees';
    protected $fillable = [
        'code',
        'user_id',
        'status',
        'start_datetime',
        'employee_type',
        'rating'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }
}

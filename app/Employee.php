<?php

namespace App;

class Employee extends BaseModel
{
    protected $table = 'employees';
    protected $fillable = [
        'code',
        'user_id',
        'status',
        'contract_at',
        'employee_type',
        'rating'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model)
        {
            $model->user()->delete();
            $model->customers()->update([ 'employee_id' => null ]);
        });
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customers() {
        return $this->hasMany(Customer::class);
    }
}

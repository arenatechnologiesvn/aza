<?php

namespace App;

class Provider extends BaseModel
{
    protected $table = 'providers';

    protected $fillable = [
        'code',
        'name',
        'logo',
        'description',
        'address',
        'phone',
        'home_phone',
        'province_code',
        'district_code',
        'zone',
        'ward_code',
        'contract_at'
    ];

    protected $hidden = [
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    protected $primaryKey = 'id';
}

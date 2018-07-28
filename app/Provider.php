<?php

namespace App;

use Plank\Mediable\Mediable;

class Provider extends BaseModel
{
    use Mediable;

    protected $table = 'providers';

    protected $fillable = [
        'code',
        'name',
        'description',
        'address',
        'zone',
        'phone',
        'home_phone',
        'province_code',
        'district_code',
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

    public function logo() {
        return $this->morphToMany('Plank\Mediable\Media', 'mediable','mediables', 'mediable_id')
        ->withPivot('mediable_type', 'tag')
        ->where([
            ['mediable_type', '=', 'App\Provider'],
            ['tag', '=', 'provider']
        ]);
    }
}

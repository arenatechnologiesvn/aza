<?php

namespace App;

class Category extends BaseModel
{
    protected $table = 'categories';

    protected $fillable = [
        'code',
        'name',
        'title',
        'url',
        'icon',
        'description',
        'parent_id',
        'lft',
        'rght'
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

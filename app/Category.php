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

    protected $primaryKey = 'id';
}

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

    public function children(){
        return $this->hasMany( 'App\Category', 'parent_id', 'id' );
    }

    public function parent(){
        return $this->belongsTo( 'App\Category', 'parent_id');
    }

}

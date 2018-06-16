<?php

namespace App;


class Permission extends BaseModel
{
    protected $fillable = [
        'level',
        'name',
        'title',
        'url_action',
        'icon'
    ];
    //
    protected $table = 'permissions';

    public function roles() {
        $this->belongsToMany(Role::class, 'role_permissions');
    }
    public function children(){
        return $this->hasMany( 'App\Permission', 'parent_id', 'id' );
    }

    public function parent(){
        return $this->belongsTo( 'App\Permission', 'parent_id');
    }
}

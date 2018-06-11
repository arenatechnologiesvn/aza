<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'level'
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

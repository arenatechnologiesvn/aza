<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'roles';
    protected $fillable = ['title','description','note', 'updated_user', 'created_user','updated_at', 'created_at'];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function permissions() {
        return $this->belongsToMany(Permission::class,'role_permissions');
    }

}

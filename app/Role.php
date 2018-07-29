<?php

namespace App;


class Role extends BaseModel
{
    //
    protected $table = 'roles';
    protected $fillable = [
        'title',
        'description',
        'note',
        'is_employee'
    ];
    protected $hidden = ['pivot'];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function permissions() {
        return $this->belongsToMany(Permission::class,'role_permissions');
    }

}

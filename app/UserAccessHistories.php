<?php

namespace App;

class UserAccessHistories extends BaseModel
{
    protected $table = 'user_access_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id'];

    public $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

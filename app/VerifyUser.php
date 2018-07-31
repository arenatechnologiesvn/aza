<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends BaseModel
{
    protected $guarded = [];

    protected $table = 'verify_users';

    protected $fillable = [
        'user_id',
        'token'
    ];

    public $primaryKey = 'id';
 
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

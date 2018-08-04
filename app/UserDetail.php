<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'sex',
        'birthday'
    ];
    //
    protected $table = 'userdetails';

    public function getDateFormat()
    {
        return 'U';
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

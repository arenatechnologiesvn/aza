<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    //
    protected $table = 'userdetails';

    public function getDateFormat()
    {
        return 'U';
    }
}

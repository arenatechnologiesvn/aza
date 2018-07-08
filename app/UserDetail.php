<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    //
    protected $table = 'userdetails';

    protected function getDateFormat()
    {
        return 'U';
    }
}

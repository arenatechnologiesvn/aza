<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/15/2018
 * Time: 11:53 PM
 */

namespace App;


use App\Observers\ByUserObserver;
use Baum\Extensions\Eloquent\Model;

abstract class BaseModel extends Model
{
    public static function boot()
    {
        $class = get_called_class();
        $class::observe(new ByUserObserver());

        parent::boot();
    }

    protected function getDateFormat()
    {
        return 'U';
    }

}

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
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use SoftDeletes;
    public $soft_deletable = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $selectable = [];
    public static function boot()
    {
        $class = get_called_class();
        $class::observe(new ByUserObserver());

        parent::boot();
    }

    public function getDateFormat()
    {
        return 'U';
    }
}

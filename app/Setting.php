<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/20/2018
 * Time: 9:59 PM
 */

namespace App;


use Baum\Extensions\Eloquent\Model;

class Setting extends BaseModel
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'global'
    ];

    protected $hidden = [
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    protected $primaryKey = 'id';
}
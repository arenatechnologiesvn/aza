<?php
/**
 * Created by PhpStorm.
 * User: dangkhoa
 * Date: 6/9/18
 * Time: 22:13
 */

namespace App;
use Baum\Node as Treeable;


class Menu extends Treeable
{
    protected $table = 'permissions';

    // 'parent_id' column name
    protected $parentColumn = 'parent_id';

    // 'lft' column name
    protected $leftColumn = 'lft';

    // 'rgt' column name
    protected $rightColumn = 'rgh';

    // 'depth' column name
    protected $depthColumn = 'level';

    // guard attributes from mass-assignment
    protected $guarded = array('id', 'parent_id', 'lft', 'rgh', 'level');

}
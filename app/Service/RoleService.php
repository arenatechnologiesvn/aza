<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/15/2018
 * Time: 9:29 AM
 */

namespace App\Service;


use App\Role;

class RoleService extends BaseService
{
    protected $selectable = [
        'id',
        'title',
        'description',
        'note',
        'is_employee'
    ];

    public function __construct(Role $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }
    protected function selectable(){
        return $this->model->with(['permissions']);
//            ->with(['roles'=> function($query) {
//            $query->select(['id']);
//            }]
//            );
    }
}
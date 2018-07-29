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

    public function afterSave($role, $data, $update = false) {
        if(isset($data['permissions']) && !empty($data['permissions'])) {
            if ($update) {
                usort($data['permissions'], function($a, $b) {
                    return $b > $a;
                });
            }
            $role->permissions()->sync($data['permissions']);
        }
    }
    protected function selectable(){
        return $this->model->with(['permissions' => function($q){
//            $ids = $q->roles()->getRelatedIds();
            $q->with('children')->where('parent_id', '=', null);
        }]);
//            ->with(['roles'=> function($query) {
//            $query->select(['id']);
//            }]
//            );
    }
}
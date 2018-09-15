<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/15/2018
 * Time: 9:29 AM
 */

namespace App\Service;


use App\Permission;
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

    public function toDto($selectable = null)
    {
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }

    public function afterSave($role, $data, $update = false)
    {
        if (isset($data['permissions']) && !empty($data['permissions'])) {
            if ($update) {
                usort($data['permissions'], function ($a, $b) {
                    return $b > $a;
                });
            }
            $role->permissions()->sync($data['permissions']);
        }
    }

    protected function selectable(){
        return $this->model->with(['permissions' => function($q){
            $q->with('children')->where('parent_id', '=', null);
        }]);
    }

    public function getById($id, $selectable = null)
    {
        $permissions = Permission::with('roles')->whereHas('roles', function ($q1) use ($id) {
            $q1->where('id', $id);
        })->select('id')->get();
        $permissions = $permissions->map(function ($item) {
            return $item['id'];
        });
        return $this->model->select($this->selectable)->with(['permissions' => function ($q) use ($permissions) {
            $q->with(['children' => function ($q1) use ($permissions) {
                $q1->whereIn('id', $permissions)->orderBy('lft');
            }])->where('parent_id', null)->whereIn('id', $permissions)->orderBy('lft');
        }])->FirstOrFail($id);
    }

}
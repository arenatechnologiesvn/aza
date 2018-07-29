<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/13/2018
 * Time: 10:42 PM
 */

namespace App\Service;


use App\Permission;

class PermissionService extends BaseService
{
    protected $selectable = [
        'id',
        'level',
        'name',
        'title',
        'url_action',
        'icon',
        'path',
        'redirect',
        'parent_id',
        'is_menu',
        'is_show',
        'authorize'
    ];

    public function __construct(Permission $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getByRole($role_id){
        return $this->model
            ->select($this->selectable)
            ->with(['children' => function ($query) {
                $query->select($this->selectable);
            }])
            ->where('parent_id', null)
            ->get();
    }
    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }
    protected function selectable(){
        return $this->model
            ->with(['roles'=> function($q) { $q->select(['id']);}]);
//            ->with(['roles'=> function($query) {
//            $query->select(['id']);
//            }]
//            );
    }
}
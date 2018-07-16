<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/15/2018
 * Time: 9:26 AM
 */

namespace App\Service;


use App\Employee;
use App\User;

class EmployeeService extends BaseService
{
    protected $selectable = [
        'id',
        'code',
        'user_id',
        'status',
        'start_datetime',
        'employee_type',
        'rating',
    ];
    private $user;
    public function __construct(Employee $model, User $user)
    {
        $this->model = $model;
        $this->user = $user;
        parent::__construct($model);
    }

    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }
    protected function selectable(){
        return $this->model->select($this->selectable)->with(['user'=> function($query) {
            $query->select([
                'id',
                'name',
                'first_name',
                'last_name',
                'email',
                'phone',
                'role_id',
                'is_active'
            ])->with(['role'=> function ($q2) {
                $q2->select(['title', 'id']);
            }]);
        }, 'customers' => function ($q) {
            $q->select(['id','employee_id']);
        }]);
    }

    public function beforeCreate($employee) {
        $user = User::create($employee['user']);
        $employee['user_id'] = $user->id;
        if (isset($employee['start_datetime'])) {
            $employee['start_datetime'] = strtotime($employee['start_datetime']);
        }
        return $employee;
    }

    public function beforeUpdate($employee, $data){
        if(isset($data['user'])) {
            unset($data['user']['password']);
            $employee->user->update($data['user']);
            unset($data['user']);
        }
        if (isset($data['start_datetime'])) {
            $data['start_datetime'] = strtotime($data['start_datetime']);
        }
        return $data;
    }
}
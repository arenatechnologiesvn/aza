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
use Illuminate\Support\Facades\DB;

class EmployeeService extends BaseService
{
    protected $selectable = [
        'id',
        'code',
        'user_id',
        'status',
        'contract_at',
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
                'is_active',
                'address'
            ])->with(['role'=> function ($q2) {
                $q2->select(['title', 'id']);
            },'userDetail']);
        }, 'customers' => function ($q) {
            $q->select(['id','employee_id']);
        }]);
    }

    public function beforeCreate($employee) {
        $user = User::create($employee['user']);
        $employee['user_id'] = $user->id;
//        if (isset($employee['start_datetime'])) {
//            $employee['start_datetime'] = strtotime($employee['start_datetime']);
//        }
        if (isset($employee['contract_at'])) {
            $employee['contract_at'] = strtotime($employee['contract_at']);
        }
        if (isset($employee['birthday'])) {
            $employee['birthday'] = strtotime($employee['birthday']);
        }
        return $employee;
    }

    public function beforeUpdate($employee, $data){
        if(isset($data['user'])) {
            unset($data['user']['password']);
            $employee->user->update($data['user']);
            unset($data['user']);
        }
        if (isset($data['birthday'])) {
            $data['birthday'] = strtotime($data['birthday']);
        }
        if (isset($data['contract_at'])) {
            $data['contract_at'] = strtotime($data['contract_at']);
        }
        return $data;
    }

    public function afterSave($updated, $data, $mode) {
        $updated->user->update($data);
        $updated->user->userDetail->update($data);
    }
}
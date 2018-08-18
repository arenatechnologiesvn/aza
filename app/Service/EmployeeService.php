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
use App\Service\MediaService;
use App\Service\AuthService;
use Illuminate\Support\Facades\DB;

class EmployeeService extends BaseService
{
    private $user;

    protected $selectable = [
        'id',
        'code',
        'user_id',
        'status',
        'contract_at',
        'employee_type',
        'rating',
    ];

    public function __construct(Employee $model, AuthService $authService, MediaService $mediaService)
    {
        $this->model = $model;
        $this->authService = $authService;
        $this->mediaService = $mediaService;
        parent::__construct($model);
    }

    public function toDto($selectable = null)
    {
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }

    protected function selectable()
    {
        return $this->model->select($this->selectable)->with(['user'=> function($query) {
            $query->select([
                'id',
                'name',
                'first_name',
                'last_name',
                'email',
                'phone',
                'address',
                'role_id',
                'is_active',
                'is_verified',
                'address'
            ])->with(['role'=> function ($q2) {
                $q2->select(['title', 'id']);
            }])->with(['avatar', 'userDetail']);
        }, 'customers' => function ($q) {
            $q->select(['id','employee_id']);
        }]);
    }

    public function beforeCreate($employee)
    {
        $user = $this->authService->register($employee['user']);
        $employee['user_id'] = $user->id;
        // if (isset($employee['contract_at'])) {
        //     $employee['contract_at'] = strtotime($employee['contract_at']);
        // }
        if (isset($employee['birthday'])) {
            $employee['birthday'] = strtotime($employee['birthday']);
        }
        return $employee;
    }

    public function beforeUpdate($employee, $data)
    {
        try {
            DB::beginTransaction();
            if(isset($data['user'])) {
                $employee->user->update($data['user']);
                unset($data['user']);
            }
            if (isset($data['birthday'])) {
                $data['birthday'] = strtotime($data['birthday']);
            }
            // if (isset($data['contract_at'])) {
            //     $data['contract_at'] = strtotime($data['contract_at']);
            // }
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function afterSave($updated, $data, $mode) {
        try {
            DB::beginTransaction();

            if (isset($data['avatar'])) {
                $this->syncMedia($updated->user_id, $data['avatar'], 'user');
            }

            if ($updated->user->userDetail) {
                $updated->user->userDetail->update($data);
            }

            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function syncMedia($user_id, $avatar)
    {
        try {
            DB::beginTransaction();
            $user = User::find($user_id);
            $this->mediaService->syncMedia($user, $avatar, 'user');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
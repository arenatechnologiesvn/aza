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
                'is_active'
            ])->with(['role'=> function ($q2) {
                $q2->select(['title', 'id']);
            }])->with(['avatar' => function($query) {
                $query->select([
                    'id',
                    \DB::raw('CONCAT("/", directory, "/", filename, ".", extension) as url')
                ]);
            }]);;
        }, 'customers' => function ($q) {
            $q->select(['id','employee_id']);
        }]);
    }

    public function beforeCreate($employee)
    {
        $user = $this->authService->register($employee['user']);
        $employee['user_id'] = $user->id;
        return $employee;
    }

    public function beforeUpdate($employee, $data)
    {
        try {
            DB::beginTransaction();
            if(isset($data['user'])) {
                $employee->user->update($data['user']);

                if ($data['user']['avatar']) {
                    $user = User::find($employee->user_id);
                    $this->mediaService->syncMedia($user, $data['user']['avatar'], 'user');
                }

                unset($data['user']);
            }
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
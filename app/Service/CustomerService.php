<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/10/2018
 * Time: 12:50 AM
 */

namespace App\Service;


use App\User;
use App\Customer;
use App\Shop;
use App\Employee;
use App\Service\MediaService;
use App\Service\AuthService;
use Illuminate\Support\Facades\DB;

class CustomerService extends BaseService
{
    protected $selectable = [
        'id',
        'code',
        'user_id',
        'customer_type',
        'status',
        'point',
        'employee_id',
        'zone',
        'province_code',
        'district_code',
        'ward_code'
    ];

    public function __construct(Customer $model, AuthService $authService, MediaService $mediaService)
    {
        $this->model = $model;
        $this->authService = $authService;
        $this->mediaService = $mediaService;
        parent::__construct($model);
    }

    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }

    public function beforeCreate($customer)
    {
        $user = $this->authService->register($customer['user']);
        $customer['user_id'] = $user->id;

        if (isset($customer['employee_code']) &&
            $employee = Employee::where('code', '=', $customer['employee_code'])->first()) {
            $customer['employee_id'] = $employee['id'];
        } else {
            throw new \Exception('Nhân viên #' . $customer['employee_code'] . ' không tồn tại');
        }

        return $customer;
    }

    public function beforeUpdate($customer, $data)
    {
        try {
            DB::beginTransaction();
            if(isset($data['user'])) {
                $customer->user->update($data['user']);
                unset($data['user']);
            }
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

            if (isset($data['shops']) && count($data['shops'])) {
                $this->syncShop($updated->id, $data['shops']);
            }
            if(!empty($data['client_name'])){
                $data['first_name'] = substr($data['client_name'], 0, strpos($data['client_name'], ' '));
                $data['last_name'] = substr($data['client_name'], strpos($data['client_name'], ' ') + 1, strlen($data['client_name']));
                unset($data['client_name']);
                $updated->user->update($data);
            }

            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function selectable() {
        return $this->model->select($this->selectable)->with([
            'favorites'=> function($q1) {
                $q1->select([
                    'product_id',
                    'customer_id'
                ]);
            },
            'carts' => function ($q2) {
                $q2->select([
                    'product_id',
                    'customer_id',
                    'quantity'
                ]);
            },
            'user' => function($q3) {
                $q3->select([
                    'id',
                    'name',
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'address',
                    'role_id',
                    'is_active',
                    'is_verified'
                ])->with(['avatar']);
            },
            'shops',
            'employee' => function($q) {
                $q->with(['user']);
            }]
        );
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

    private function syncShop($customer_id, $shops)
    {
        try {
            DB::beginTransaction();
            Shop::whereIn('id', $shops)->update(array('customer_id' => $customer_id));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

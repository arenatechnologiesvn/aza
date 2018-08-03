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

            if ($data['avatar']) {
                $this->syncMedia($updated->user_id, $data['avatar'], 'user');
            }

            if (count($data['shops'])) {
                $this->syncShop($updated->id, $data['shops']);
            }

            // if(!empty($data['name'])){
            //     $data['first_name'] = substr($data['name'], 0, strpos($data['name'], ' '));
            //     $data['last_name'] = substr($data['name'], strpos($data['name'], ' ') + 1, strlen($data['name']));
            //     unset($data['name']);
            // $updated->user->update($data);
            // }

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
                    'is_active'
                ])->with([
                    'avatar' => function($q4) {
                        $q4->select([
                            'id',
                            \DB::raw('CONCAT("/", directory, "/", filename, ".", extension) as url')
                        ]);
                    }
                ]);
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

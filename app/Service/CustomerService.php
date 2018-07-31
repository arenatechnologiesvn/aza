<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/10/2018
 * Time: 12:50 AM
 */

namespace App\Service;


use App\Customer;

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

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }

    public function afterSave($updated, $data, $mode) {
        if(!empty($data['name'])){
            $data['first_name'] = substr($data['name'], 0, strpos($data['name'], ' '));
            $data['last_name'] = substr($data['name'], strpos($data['name'], ' ') + 1, strlen($data['name']));
            unset($data['name']);
        }
        $updated->user->update($data);
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
}

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
        'status',
        'address',
        'customer_type',
        'point',
        'employee_id',
        'province_code',
        'district_code',
        'ward_code',
        'sex'
    ];

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }

    public function afterSave($updated, $data, $mode) {
        if(!empty($data['client_name'])){
            $data['first_name'] = substr($data['client_name'], 0, strpos($data['client_name'], ' '));
            $data['last_name'] = substr($data['client_name'], strpos($data['client_name'], ' ') + 1, strlen($data['client_name']));
            unset($data['client_name']);
        }
        $updated->user->update($data);
    }

    protected function selectable(){
        return $this->model->select($this->selectable)->with(['favorites'=> function($query) {
            $query->select([
                'product_id',
                'customer_id'
            ]);
        }, 'carts' => function ($q2) {
            $q2->select([
                'product_id',
                'customer_id',
                'quantity'
            ]);
        },'user','shops','employee' => function($q) {
            $q->with(['user']);
        }]);
    }
}
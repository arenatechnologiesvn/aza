<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/10/2018
 * Time: 12:50 AM
 */

namespace App\Service;


use App\Customer;

class CustomerService
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function handleGetAll()
    {
        return $this->customer->select(['employee_id', 'user_id'])->with(['user' => function ($query) {
            $query->select(['id']);
        }, 'employee'])->get();
    }
}
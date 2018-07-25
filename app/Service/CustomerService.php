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

    public function getAll()
    {
        return $this->customer->select(['id', 'code', 'employee_id', 'user_id'])->with(['user' => function ($query) {
            $query->select(['id', 'name', 'first_name']);
        }, 'employee'])->get();
    }
}
<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\Customers\StoreCustomerCreate;
use App\Http\Requests\Customers\StoreCustomerUpdate;
use App\Service\CustomerService;

class CustomerController extends CrudController
{

    public function __construct(Customer $customer, CustomerService $service)
    {
        $this->model = $customer;
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerCreate $request)
    {
        return $this->save($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomerUpdate $request, $id)
    {
        return $this->edit($request->all(), $id);
    }
}

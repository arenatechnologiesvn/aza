<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\Customers\StoreCustomerCreate;
use App\Http\Requests\Customers\StoreCustomerBulkCreate;
use App\Http\Requests\Customers\StoreCustomerUpdate;
use App\Service\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Bulk store the newly created resources in storage.
     *
     * @param  \Illuminate\Http\StoreCustomerBulkCreate  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkStore(StoreCustomerBulkCreate $request)
    {
        return $this->bulkCreate($request->all());
    }
}

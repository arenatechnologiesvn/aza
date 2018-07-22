<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\Customers\CustomerCreateRequest;
use App\Http\Responses\Customers\CustomerCreateResponse;
use App\Http\Responses\Customers\CustomerGetByIdResponse;
use App\Http\Responses\Customers\CustomerIndexResponse;
use App\Http\Responses\Customers\CustomerUpdateResponse;
use App\Service\CustomerService;
use Illuminate\Http\Request;

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
    public function store(CustomerCreateRequest $request)
    {
        //
        return $this->save($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->all();
        unset($data['password']);
        if (isset($data['selectedProvince'])) {
            $data['province_code'] = $data['selectedProvince']['selectedProvince'];
            $data['district_code'] = $data['selectedProvince']['selectedDistrict'];
            $data['ward_code'] = $data['selectedProvince']['selectedWard'];
        }
        $customer = $this->model->find($id);
        $customer->update($data);
        $this->returnData = $customer->user->update($data);
        return $this->responseApi();
    }
}

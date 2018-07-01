<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\Customers\CustomerCreateRequest;
use App\Http\Responses\Customers\CustomerCreateResponse;
use App\Http\Responses\Customers\CustomerGetByIdResponse;
use App\Http\Responses\Customers\CustomerIndexResponse;
use App\Http\Responses\Customers\CustomerUpdateResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return new CustomerIndexResponse();
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
        return new CustomerCreateResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $customer = $this->customer->find($id);
        return $customer ? new CustomerGetByIdResponse($customer) :
            new FailedResponse(404, "File not found");;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data['province_code'] = $data['selectedProvince']['selectedProvince'];
        $data['district_code'] = $data['selectedProvince']['selectedDistrict'];
        $data['ward_code'] = $data['selectedProvince']['selectedWard'];
        $customer = $this->customer->find($id);
        $customer->update($data);
        $customer->user->update($data);
        return new CustomerUpdateResponse($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

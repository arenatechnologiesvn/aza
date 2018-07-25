<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/25/2018
 * Time: 6:53 AM
 */

namespace App\Http\Controllers;


use App\Order;
use App\Service\OrderService;

class OrderController extends CrudController
{
    public function __construct(Order $model, OrderService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(CustomerCreateRequest $request)
//    {
//        //
//        return $this->save($request->all());
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//        //
//        $data = $request->all();
//        unset($data['password']);
//        if (isset($data['selectedProvince'])) {
//            $data['province_code'] = $data['selectedProvince']['selectedProvince'];
//            $data['district_code'] = $data['selectedProvince']['selectedDistrict'];
//            $data['ward_code'] = $data['selectedProvince']['selectedWard'];
//        }
//        $customer = $this->model->find($id);
//        $customer->update($data);
//        $this->returnData = $customer->user->update($data);
//        return $this->responseApi();
//    }
}
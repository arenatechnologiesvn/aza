<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/25/2018
 * Time: 6:53 AM
 */

namespace App\Http\Controllers;


use App\Http\Requests\Orders\StoreOrderFormRequest;
use App\Http\Requests\Orders\UpdateOrderFormRequest;
use App\Order;
use App\Service\OrderService;
use Illuminate\Http\Request;

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
    public function store(StoreOrderFormRequest $request)
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
    public function update(UpdateOrderFormRequest $request, $id)
    {
        return $this->edit($request->all(), $id);
    }

    /**
     * Bulk update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkUpdate(Request $request)
    {
        return $this->bulkEdit($request->all());
    }
}
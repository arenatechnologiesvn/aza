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
    public function store(Request $request)
    {
        try {
            return $this->save($request->all());
        } catch(\Exception $e){
            return $e;
        }
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
        try {
            return $this->edit($request->all(), $id);
        } catch(\Exception $e){
            return $e;
        }
    }

    public function bulkUpdate(Request $request)
    {
        try {
            $params = $request->all();
            return $this->service->bulkUpdate($params['ids'], $params['data']);
        } catch(\Exception $e){
            return $e;
        }
    }
}
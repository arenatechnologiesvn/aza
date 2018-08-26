<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/13/2018
 * Time: 10:31 PM
 */

namespace App\Http\Controllers;


abstract class CrudController extends Controller
{
    protected $service;
    protected $returnData;
    protected $model;

    /*
     * Return data to client
     * @return \Illuminate\Http\Response
     * */
    protected function responseApi(){
        return $this->returnData ?
            $this->api_success_response(['data' => $this->returnData]):
            $this->api_error_response(['message' => 'Error Server']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->returnData = $this->service->getAll();
        return $this->responseApi();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->returnData = $this->service->getById($id);
        return $this->responseApi();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save($data){
        try {
            $entity = $this->service->create($data);
            return $this->api_success_response(['data' => $entity]);
        } catch(\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    /**
     * Bulk create the specified resource in storage.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function bulkCreate($data)
    {
        try {
            $this->service->bulkCreate($data);
            return $this->api_success_response(['data' => true]);
        } catch(\Exception $e){
            return $this->api_error_response($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($data, $id)
    {
        try {
            $entity = $this->service->update($id, $data);
            return $this->api_success_response(['data' => $entity]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }

    }

    /**
     * Bulk update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function bulkEdit($data)
    {
        try {
            $resutls = $this->service->bulkUpdate($data['ids'], $data['data']);
            return $this->api_success_response(['data' => $resutls]);
        } catch(\Exception $e){
            return $this->api_error_response($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->service->destroy($id);
            return $this->api_success_response(['data' => $deleted]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }

    }
}

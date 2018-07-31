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
        $entity = $this->service->create($data);
        return $this->api_success_response(['data' => $entity]);
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
        $entity = $this->service->update($id, $data);
        return $this->api_success_response(['data' => $entity]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->api_success_response(['data' => $id]);
        $deleted  = $this->service->destroy($id);
        return $this->api_success_response(['data' => $deleted]);
    }
}

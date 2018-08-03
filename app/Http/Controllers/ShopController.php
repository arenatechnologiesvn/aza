<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shops\StoreShop;
use App\Service\ShopService;
use App\Shop;

class ShopController extends CrudController
{
    public function __construct(Shop $shop, ShopService $service)
    {
        $this->model = $shop;
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShop $request)
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
    public function update(StoreShop $request, $id)
    {
        return $this->edit($request->all(), $id);
    }
}

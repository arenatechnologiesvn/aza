<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shops\ShopCreateRequest;
use App\Http\Responses\FailedResponse;
use App\Http\Responses\Shops\ShopCreateResponse;
use App\Http\Responses\Shops\ShopGetIndexByIdResponse;
use App\Http\Responses\Shops\ShopIndexResponse;
use App\Http\Responses\Shops\ShopUpdateResponse;
use App\Service\ShopService;
use App\Shop;
use Illuminate\Http\Request;

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
    public function store(ShopCreateRequest $request)
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
    public function update(Request $request, $id)
    {
        return $this->edit($request->all(), $id);
    }
}

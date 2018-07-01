<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shops\ShopCreateRequest;
use App\Http\Responses\FailedResponse;
use App\Http\Responses\Shops\ShopCreateResponse;
use App\Http\Responses\Shops\ShopGetIndexByIdResponse;
use App\Http\Responses\Shops\ShopIndexResponse;
use App\Http\Responses\Shops\ShopUpdateResponse;
use App\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return new ShopIndexResponse();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopCreateRequest $request)
    {
        //
        return new ShopCreateResponse();
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
        $shop = $this->shop->find($id);
        return $shop ? new ShopGetIndexByIdResponse($shop) : new FailedResponse(404, 'File Not Found');
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
        $data['province_code'] = $data['selectedProvince']['selectedProvince'];
        $data['district_code'] = $data['selectedProvince']['selectedDistrict'];
        $data['ward_code'] = $data['selectedProvince']['selectedWard'];
        $shop = $this->shop->find($id);
        $shop->update($data);
        return new ShopUpdateResponse($shop);
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

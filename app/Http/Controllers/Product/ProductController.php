<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProduct;
use App\Service\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->service->getAllProducts();
        return $this->api_success_response(['data' => $products]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        if ($request->input('discount_price') &&
            ($request->input('discount_price') > $request->input('price'))) {
            return $this->api_error_response('price must be greater than discount price', 401);
        }

        $product = $this->service->storeProduct($request->all());
        return $this->api_success_response(['data' => $product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->service->getProductById($id);
        return $this->api_success_response(['data' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, StoreProduct $request)
    {
        if ($request->input('discount_price') &&
            ($request->input('discount_price') > $request->input('price'))) {
            return $this->api_error_response('price must be greater than discount price', 401);
        }

        $product = $this->service->updateProduct($product, $request->all());
        return $this->api_success_response(['data' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->service->deleteProduct($id);
        return $this->api_success_response();
    }
}

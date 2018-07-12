<?php

namespace App\Http\Controllers\Product;

use App\Provider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Provider::all();
        return $this->api_success_response(['data' => $providers]);
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
    public function store(StoreProvider $request)
    {
        \DB::beginTransaction();
        try {
            $provider = Provider::create($request->all());
            \DB::commit();
            return $this->api_success_response([ 'data' => $provider ]);
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->api_error_response($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $data = [
            'id' => $category['id'],
            'code' => $category['code'],
            'name' => $category['name'],
            'icon' => $category['icon'],
            'description' => $category['description']
        ];

        return $this->api_success_response(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request, Category $category)
    {
        \DB::beginTransaction();
        try {
            $category->update($request->all());
            \DB::commit();
            return $this->api_success_response(['data' => $category]);
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->api_error_response($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        \DB::beginTransaction();
        try {
            $result = $category->delete();
            \DB::commit();
            return $this->api_success_response();
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->api_error_response($e->getMessage(), 500);
        }
    }
}

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
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        return $this->api_success_response(['data' => $provider]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProvider $request, Provider $provider)
    {
        \DB::beginTransaction();
        try {
            $provider->update($request->all());
            \DB::commit();
            return $this->api_success_response(['data' => $provider]);
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->api_error_response($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        \DB::beginTransaction();
        try {
            $result = $provider->delete();
            \DB::commit();
            return $this->api_success_response();
        } catch (\Exception $e) {
            \DB::rollback();
            return $this->api_error_response($e->getMessage(), 500);
        }
    }
}

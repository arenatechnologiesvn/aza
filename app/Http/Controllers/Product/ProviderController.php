<?php

namespace App\Http\Controllers\Product;

use App\Provider;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProvider;
use App\Service\ProviderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProviderController extends Controller
{
    public function __construct(ProviderService $service)
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
        $providers = $this->service->getAll();
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
        $provider = $this->service->create($request->all());
        return $this->api_success_response(['data' => $provider]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provider = $this->service->getById($id);
        if ($provider && $provider->logo) {
            $logo = $provider->logo;
            unset($provider->logo);
            $provider->logo = count($logo) ? $logo[0] : null;
        }

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
    public function update(StoreProvider $request, $id)
    {
        $provider = $this->service->update($id, $request->all());
        return $this->api_success_response(['data' => $provider]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provider = $this->service->destroy($id);
        return $this->api_success_response(['data' => $provider]);
    }
}

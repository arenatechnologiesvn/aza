<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/23/2018
 * Time: 11:50 PM
 */

namespace App\Http\Controllers;

use App\Http\Requests\Carts\StoreCartFormRequest;
use App\Service\CartService;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    public function index(){
        try {
            return $this->api_success_response( ['data' => $this->service->index()]);
        } catch (Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function store (StoreCartFormRequest $request) {
        try {
           return $this->api_success_response( ['data' => $this->service->store($request->all())]);
        } catch (Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function storeAll (Request $request) {
        try {
            return $this->api_success_response( ['data' => $this->service->storeAll($request->all())]);
        } catch (Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function update(Request $request, $id) {
        try {
            return $this->api_success_response(['data' => $this->service->update($request->all(), $id)]);
        } catch (Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function destroy($id) {
        try {
            return $this->api_success_response(['data' => $this->service->destroy($id)]);
        } catch (Exception $e) {
            return $this->api_error_response($e);
        }
    }
}
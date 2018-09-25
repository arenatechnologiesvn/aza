<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/23/2018
 * Time: 11:50 PM
 */

namespace App\Http\Controllers;

use App\Http\Requests\Carts\BulkStoreCartFormRequest;
use App\Http\Requests\Carts\StoreCartFormRequest;
use App\Http\Requests\Carts\UpdateCartFormRequest;
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
            $cart = $this->service->store($request->all());
            if ($cart!=null)
                return $this->api_success_response( ['data' => $cart]);
            return $this->timeoutApply();
        } catch (Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function storeAll (BulkStoreCartFormRequest $request) {
        try {
            $carts = $this->service->storeAll($request->all());
            if ($carts!=null)
                return $this->api_success_response( ['data' =>$carts]);
            return $this->timeoutApply();
        } catch (Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function update(UpdateCartFormRequest $request, $id) {
        try {
            $cart = $this->service->update($request->all(), $id);
            if ($cart!=null)
                return $this->api_success_response(['data' => $cart]);
            return $this->timeoutApply();
        } catch (Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function destroy($id) {
        try {
            $cart = $this->service->destroy($id);
            if ($cart != null)
                return $this->api_success_response(['data' => $cart]);
            return $this->timeoutApply();
        } catch (Exception $e) {
            return $this->api_error_response($e);
        }
    }

    private function timeoutApply(){
        return $this->api_error_response('Không thể đặt hàng lúc này', 'Không thể đặt hàng lúc này');

    }
}
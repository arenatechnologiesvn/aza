<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/23/2018
 * Time: 11:50 PM
 */

namespace App\Http\Controllers;


use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index(){
        $customer = $this->customer->where('user_id', Auth::user()->id)->firstOrFail();
        $carts = isset($customer->favorites) ? json_decode($customer->carts, true) : [] ;
        return $this->api_success_response( $carts);
    }

    public function show($id){
        $customer = $this->customer->where('user_id', Auth::user()->id)->firstOrFail();
        $carts = isset($customer->favorites) ? json_decode($customer->carts, true) : [] ;
        $cart = count($carts) > 0 ? array_filter($carts, function($item) use($id){
            return $item['product_id'] == $id;
        }) : [];
        return $this->api_success_response( $cart);
    }

    public function store (Request $request) {
        $product_id = $request->get('product_id');
        $quantity = $request->get('quantity');
        $customer = $this->customer->where('user_id', Auth::user()->id)->firstOrFail();
        $carts = isset($customer->carts) ? json_decode($customer->carts, true) : [] ;
        if (!$this->checkExist($product_id, $carts)){
            $carts[] = ['product_id' => $product_id, 'quantity' => $quantity];
            $customer->carts = json_encode($carts);
            $customer->save();
        }
        return $this->api_success_response($carts);
    }

    public function update(Request $request, $id = null) {
        $customer = $this->customer->where('user_id', Auth::user()->id)->firstOrFail();
        $carts = isset($customer->favorites) ? json_decode($customer->favorites, true) : [] ;
        if (($key = array_search($id, array_column($carts, 'product_id'))) !== false){
            $carts[$key] = ['product_id' => $id, 'quantity' => $request->get('quantity')];
            $customer->carts = json_encode($carts);
            $customer->save();
        }
        return $this->api_success_response($carts);
    }

    public function destroy($id) {
        $customer = $this->customer->where('user_id', Auth::user()->id)->firstOrFail();
        $carts = isset($customer->favorites) ? json_decode($customer->favorites, true) : [] ;
        if (($key = array_search($id, array_column($carts, 'product_id'))) !== false){
            unset($carts[$key]);
            $customer->carts = json_encode($carts);
            $customer->save();
        }
        return $this->api_success_response($carts);
    }

    private function checkExist ($product_id, $carts) {
        if (count($carts) < 1) return false;
        return array_filter($carts, function ($e) use ($product_id) {
            return $e['product_id'] == $product_id;
        });
    }
}
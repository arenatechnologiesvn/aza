<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/23/2018
 * Time: 11:50 PM
 */

namespace App\Http\Controllers;


use App\Cart;
use App\Customer;
use App\Helper\RoleConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $model;

    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function index(){
        try {
            $carts = $this->model->where('customer_id', '=', $this->getCustomerId())->get();
            return $this->api_success_response( ['data' => $carts ]);
        } catch (\Exception $e) {
            return $this->api_error_response( $e);
        }
    }

    public function store (Request $request) {
        try {
            $cart = new Cart;
            $cart->create($request->all());
            return $this->api_success_response( ['data' => $this->getByProductId($request->get('product_id'))]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function update(Request $request, $id) {
        try {
            $this->model->where([
                ['customer_id', '=', $this->getCustomerId()],
                ['product_id', '=', $id]
            ])->update(['quantity' => $request->get('quantity')]);
            return $this->api_success_response(['data' => $this->getByProductId($id)]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function destroy($id) {
        try {
            $cart = $this->model->where([
                ['customer_id', '=', $this->getCustomerId()],
                ['product_id', '=', $id]
            ])->delete();
            return $this->api_success_response(['data' => $cart]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    private function getCustomerId (){
        try {
            if (Auth::user()->role_id == RoleConstant::Customer){
                return Customer::where('user_id', '=', Auth::user()->id)->firstOrFail()->id;
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getByProductId ($product_id) {
        return  $this->model->where([
            ['customer_id', '=', $this->getCustomerId()],
            ['product_id', '=', $product_id]
        ])->firstOrFail();
    }
}
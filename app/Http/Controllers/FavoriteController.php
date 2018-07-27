<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/22/2018
 * Time: 9:20 AM
 */

namespace App\Http\Controllers;


use App\Customer;


use App\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    private $model;

    public function __construct(Favorite $model)
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
            $carts = $this->model->save($request->all());
            return $this->api_success_response( $carts);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function update(Request $request, $id = null) {
        try {
            $cart = $this->model->where([
                ['customer_id', '=', $this->getCustomerId()],
                ['product_id', '=', $id]
            ])->firstOrFail();
            if ($cart) $cart->update($request->all());
            return $this->api_success_response(['data' => $cart]);
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
            return $this->api_success_response($cart);
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
}
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
use App\Service\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $model;
    private $setting;

    public function __construct(Cart $model, SettingService $setting)
    {
        $this->model = $model;
        $this->setting = $setting;
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
            $n = $this->setting->action('get', 'apply');
            $n = json_decode($n, true)['value'];
            if ($this->timeFormat() > $n['start'] && $this->timeFormat() < $n['end'] ) {
                $cart = new Cart;
                $cart->create($request->all());
                return $this->api_success_response( ['data' => $this->getByProductId($request->get('product_id'))]);
            }else {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    private function timeFormat() {
        $now = now();
        $h = $now->hour;
        $minute = $now->minute;
        return $h.":".$minute;
    }
    public function storeAll (Request $request) {
        try {
            $n = $this->setting->action('get', 'apply');
            $n = json_decode($n, true)['value'];
            if ($this->timeFormat() > $n['start'] && $this->timeFormat() < $n['end'] ) {
                $data = $request->all();
                foreach($data as $item) {
                    $cart = new Cart;
                    $cart->create($item);
                }
                return $this->api_success_response( ['data' => $data]);
            }else {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function update(Request $request, $id) {
        try {
            $n = $this->setting->action('get', 'apply');
            $n = json_decode($n, true)['value'];
            if ($this->timeFormat() > $n['start'] && $this->timeFormat() < $n['end'] ) {
                $this->model->where([
                    ['customer_id', '=', $this->getCustomerId()],
                    ['product_id', '=', $id]
                ])->update(['quantity' => $request->get('quantity')]);
                return $this->api_success_response(['data' => $this->getByProductId($id)]);
            }else {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function destroy($id) {
        try {
            $n = $this->setting->action('get', 'apply');
            $n = json_decode($n, true)['value'];
            if ($this->timeFormat() > $n['start'] && $this->timeFormat() < $n['end'] ) {
                $cart = $this->model->where([
                    ['customer_id', '=', $this->getCustomerId()],
                    ['product_id', '=', $id]
                ])->delete();
                return $this->api_success_response(['data' => $cart]);
            }else {
                throw new \Exception();
            }

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

    private function checkExistInCart($product_id, $customer_id) {
        return count($this->model->where([['customer_id', '=', $customer_id], ['product_id', '=', $product_id]]).get()) > 0;
    }
    private function getByProductId ($product_id) {
        return  $this->model->where([
            ['customer_id', '=', $this->getCustomerId()],
            ['product_id', '=', $product_id]
        ])->firstOrFail();
    }
}
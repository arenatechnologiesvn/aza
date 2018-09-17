<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/27/2018
 * Time: 1:15 AM
 */

namespace App\Service;


use App\Cart;
use App\Customer;
use App\Helper\RoleConstant;
use Exception;
use Illuminate\Support\Facades\Auth;

class CartService
{
    private $setting;
    private $model;

    public function __construct(Cart $model, SettingService $settingService)
    {
        $this->model = $model;
        $this->setting = $settingService;
    }

    public function index(){
        try {
            $carts = $this->model->where('customer_id', '=', $this->getCustomerId())->get();
            return $carts;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            if ($this->checkTime()) {
                $product_id = $data['product_id'];
                $customer_id = $data['customer_id'];
                $cart = $this->model->where([
                    ['product_id', '=', $product_id],
                    ['customer_id', '=', $customer_id]
                ])->first();
                if ($cart !=null) {
                    $data['quantity'] = $cart->quantity + 1;
                    return $this->update($data, $product_id);
                } else {
                    $cart = Cart::create($data);
                    return $cart;
                }
            }else {
                throw new Exception("Không thể đặt hàng ngoài khung giờ");
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function storeAll ($data) {
        try {
            if ($this->checkTime()) {
                foreach($data as $item) {
                    if ( $this->checkExistInCart($item['product_id'], $item['customer_id']) == null){
                        $cart = new Cart;
                        $cart->create($item);
                    }
                }
                return $data;
            }else {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function update($data, $id) {
        try {
            if ($this->checkTime()) {
                $this->model->where([
                    ['customer_id', '=', $this->getCustomerId()],
                    ['product_id', '=', $id]
                ])->update(['quantity' => $data['quantity']]);
                return $this->getByProductId($id);
            }else {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            return $e;
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
                return $cart;
            }else {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            return $e;
        }
    }

    private function timeFormat() {
        $now = now();
        $h = $now->hour;
        $minute = $now->minute;
        return $h.":".$minute;
    }
    private function checkTime () {
        $n = $this->setting->action('get', 'apply');
        $n = json_decode($n, true)['value'];
        return intval($this->timeFormat()) >= intval($n['start'] )&& intval($this->timeFormat()) <= intval($n['end']);
    }

    private function getCustomerId (){
        try {
            if (Auth::user()->role_id == RoleConstant::Customer){
                return Customer::where('user_id', '=', Auth::user()->id)->firstOrFail()->id;
            }
            return 0;
        } catch (\Exception $e) {
            return $e;
        }
    }

    private function checkExistInCart($product_id, $customer_id) {
        try {
            return $this->model->where([['customer_id', '=', $customer_id], ['product_id', '=', $product_id]])->firstOrFail();
        } catch (\Exception $e) {
            return null;
        }

    }
    private function getByProductId ($product_id) {
        return  $this->model->where([
            ['customer_id', '=', $this->getCustomerId()],
            ['product_id', '=', $product_id]
        ])->firstOrFail();
    }
}
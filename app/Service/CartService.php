<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/27/2018
 * Time: 1:15 AM
 */

namespace App\Service;


use App\Cart;
use App\Favorite;
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
                return null;
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function bulkStore($data) {
        try {
            if ($this->checkTime()) {
                $currentCustomer = $this->getCustomerId();
                $existedCartProducts = $this->model
                    ->where('customer_id', '=', $currentCustomer)
                    ->pluck('product_id')->toArray();
                foreach($data as $item) {
                    if (!in_array($item['product_id'], $existedCartProducts)) {
                        $cart = new Cart;
                        $cart->create([
                            'customer_id' => $currentCustomer,
                            'product_id' => $item['product_id'],
                            'quantity' => 0
                        ]);
                    }
                }

                return $this->model->where('customer_id', '=', $currentCustomer)->get();
            }
            return null;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function storeAll() {
        try {
            if ($this->checkTime()) {
                $currentCustomer = $this->getCustomerId();
                $existedCartProducts = $this->model
                    ->where('customer_id', '=', $currentCustomer)
                    ->pluck('product_id')->toArray();
                $favoriteProducts = Favorite::where('customer_id', '=', $currentCustomer)
                    ->pluck('product_id')->toArray();
                foreach($favoriteProducts as $favoriteProduct) {
                    if (!in_array($favoriteProduct, $existedCartProducts)) {
                        $cart = new Cart;
                        $cart->create([
                            'customer_id' => $currentCustomer,
                            'product_id' => $favoriteProduct,
                            'quantity' => 0
                        ]);
                    }
                }

                return $this->model->where('customer_id', '=', $currentCustomer)->get();
            }
            return null;
        } catch (Exception $e) {
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
                return null;
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function destroy($id) {
        try {
            if ($this->checkTime()) {
                $cart = $this->model->where([
                    ['customer_id', '=', $this->getCustomerId()],
                    ['product_id', '=', $id]
                ])->delete();
                return $cart;
            }else {
                return null;
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function destroyAll() {
        try {
            if ($this->checkTime()) {
                $this->model->where('customer_id', '=', $this->getCustomerId())->delete();
                return true;
            }
            return false;
        } catch (Exception $e) {
            return $e;
        }
    }

    private function checkTime () {
        $orderTimes = $this->setting->action('get', 'apply');
        $orderTimes = json_decode($orderTimes, true)['value'];

        $now = new \DateTime();
        $startOrderTime = new \DateTime($now->format('Y-m-d') . ' ' . $orderTimes['start']);
        $endOrderTime = new \DateTime($now->format('Y-m-d') . ' ' . $orderTimes['end']);

        if ($orderTimes['is_end_in_today']) return $startOrderTime < $now && $now <= $endOrderTime;
        return !($endOrderTime < $now && $now <= $startOrderTime);
    }

    private function getCustomerId (){
        try {
            if (Auth::user()->role_id == RoleConstant::Customer){
                return Customer::where('user_id', '=', Auth::user()->id)->firstOrFail()->id;
            }
            return 0;
        } catch (Exception $e) {
            return $e;
        }
    }

    private function getByProductId ($product_id) {
        return  $this->model->where([
            ['customer_id', '=', $this->getCustomerId()],
            ['product_id', '=', $product_id]
        ])->firstOrFail();
    }
}
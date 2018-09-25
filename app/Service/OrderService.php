<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/25/2018
 * Time: 6:54 AM
 */

namespace App\Service;


use App\Cart;
use App\Helper\RoleConstant;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    protected $selectable = [
        'id',
        'order_code',
        'title',
        'description',
        'approve_employee',
        'approve_note',
        'status',
        'customer_id',
        'apply_at',
        'delivery',
        'delivery_type',
        'delivery_address',
        'total_money',
        'shop_id'
    ];
    private $setting;
    private $customerService;
    public function __construct(Order $model, SettingService $service, CustomerService $customerService)
    {
        $this->model = $model;
        $this->setting = $service;
        $this->customerService = $customerService;
        parent::__construct($model);
    }

    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }
    protected function selectable(){
        return $this->selectByRole();
    }


    public function beforeCreate($order) {
        $order['order_code'] = 'DH-'.time();
        $order['status'] = 1;
        // Delete cart before save order
        $customer_id = Customer::select(['id'])->where('user_id', '=', Auth::user()->id)->firstOrFail()->id;
        if($customer_id) Cart::where('customer_id', '=', $customer_id)->delete();

        if(empty($order['customer_id']))
            $order['customer_id'] = Customer::select(['id'])->where('user_id', '=',Auth::user()->id)->firstOrFail()->id;
        if(!empty($order['delivery'])) {
            $order['delivery'] = strtotime($order['delivery']);
        }
        $order['apply_at'] = time();
        return $order;
    }

     public function beforeUpdate($order, $data){
         if(!empty($data['delivery'])) {
             $data['delivery'] = strtotime($data['delivery']);
         }
         return $data;
     }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            if (method_exists($this, 'beforeCreate')) {
                $data = $this->beforeCreate($data);
            }
            if ($this->checkTime()) {
                $saved = $this->model->create($data);
            } else {
                return null;
            }
            if(method_exists($this, 'afterSave')) {
                $this->afterSave($saved, $data, false);
            }
            DB::commit();
            return $this->getById($saved->id);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function afterSave($order, $data, $update = false) {
        if (isset($data['status']) && $data['status'] == 0) {
            try {
                $general = $this->setting->action('get', 'general');
                $general = json_decode($general, true)['value'];
                $scorePoint = $general['score'];
                $this->customerService->setScore($order->customer_id, (int) (floatval($order->total_money) / intval($scorePoint)));
            } catch (\Exception $e) {
                return $e;
            }
        }
        if(!empty($data['product'])) {
            if ($update) {
                usort($data['product'], function($a, $b) {
                    return $b['product_id'] > $a['product_id'];
                });
            }
            $order->products()->sync($data['product']);
        }
        $this->updateTotal($order->id);
    }

    private function updateTotal ($order_id)
    {
        try {
            \DB::beginTransaction();
            $total = DB::table('order_product')
                ->select([
                    DB::raw('SUM(quantity * real_price) as total')
                ])->where('order_id', '=', $order_id)->get()->first()->total;
            DB::table('orders')
                ->where('id', $order_id)
                ->update(['total_money'=> $total ]);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    private function selectByRole() {
        if(Auth::user()->role_id == RoleConstant::Customer){
            return $this->model->select($this->selectable)->with(['products'=> function($query) {
                $query->select([
                    'id',
                    'name',
                    'description',
                    'price',
                    'unit',
                    'quantitative',
                    'provider_id'
                ])->with(['provider'=> function ($q2) {
                    $q2->select(['id', 'name']);
                },'featured' => function ($q3) {
                    $q3->select([
                        'id',
                        DB::raw('CONCAT("/", directory, "/", filename, ".", extension) as url')
                    ]);
                }]);
            },'shop', 'customer' => function($q) {
                $q->with(['user']);
            }])->where('customer_id', '=', Customer::where('user_id', '=', Auth::user()->id)->firstOrFail()->id);
        } else {
            return $this->model->select($this->selectable)->with(['products'=> function($query) {
                $query->select([
                    'id',
                    'name',
                    'description',
                    'price',
                    'unit',
                    'quantitative',
                    'provider_id',
                ])->with(['provider'=> function ($q2) {
                    $q2->select(['id', 'name']);
                }, 'featured' => function ($q3) {
                    $q3->select([
                        'id',
                        DB::raw('CONCAT("/", directory, "/", filename, ".", extension) as url')
                    ]);
                }]);
            },'customer' => function ($q3) {
                $q3->with(['user']);
            }, 'shop']);
        }
    }

    public function getByIds($ids) {
        return $this->model->select($this->selectable)->with(['products'=> function($query) {
            $query->select([
                'id',
                'name',
                'description',
                'price',
                'unit',
                'quantitative',
                'provider_id',
            ])->with(['provider'=> function ($q2) {
                $q2->select(['id', 'name']);
            }, 'featured' => function ($q3) {
                $q3->select([
                    'id',
                    DB::raw('CONCAT("/", directory, "/", filename, ".", extension) as url')
                ]);
            }]);
        },'customer' => function ($q3) {
            $q3->with(['user']);
        }, 'shop'])->whereIn('id', $ids)->get();
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
}
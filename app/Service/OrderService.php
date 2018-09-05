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
    public function __construct(Order $model, SettingService $service)
    {
        $this->model = $model;
        $this->setting = $service;
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

    // public function beforeUpdate($employee, $data){

    // }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            if (method_exists($this, 'beforeCreate')) {
                $data = $this->beforeCreate($data);
            }
            $n = $this->setting->action('get', 'apply');
            $n = json_decode($n, true)['value'];
            if ($this->timeFormat() > $n['start'] && $this->timeFormat() < $n['end'] ) {
                $saved = $this->model->create($data);
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
    private function timeFormat() {
        $now = now();
        $h = $now->hour;
        $minute = $now->minute;
        return $h.":".$minute;
    }

    public function afterSave($order, $data, $update = false) {
        if(!empty($data['product'])) {
            if ($update) {
                usort($data['product'], function($a, $b) {
                    return $b['product_id'] > $a['product_id'];
                });
            }
            $order->products()->sync($data['product']);
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
}
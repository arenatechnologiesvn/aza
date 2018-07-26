<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/25/2018
 * Time: 6:54 AM
 */

namespace App\Service;


use App\Order;
use App\ProductOrder;
use function foo\func;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Customer;
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
        'total_money'
    ];
    public function __construct(Order $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }
    protected function selectable(){
        return $this->model->select($this->selectable)->with(['products'=> function($query) {
            $query->select([
                'id',
                'name',
                'description',
                'price',
                'unit',
                'provider_id'
            ])->with(['provider'=> function ($q2) {
                $q2->select(['id', 'name']);
            }]);
        }]);
    }

    public function beforeCreate($order) {
        $order['order_code'] = 'DH-'.time();
        if(empty($order['customer_id']))
            $order['customer_id'] = Customer::select(['id'])->where('user_id', '=',Auth::user()->id)->firstOrFail()->id;
        $order['status'] = 1;
        return $order;
    }

    // public function beforeUpdate($employee, $data){

    // }

    public function afterSave($order, $data, $update = false) {
        if($data['product'] != false) {
            if ($update) {
                usort($data['product'], function($a, $b) {
                    return $b['product_id'] > $a['product_id'];
                });
            }
            $order->products()->sync($data['product']);
        }
    }
}
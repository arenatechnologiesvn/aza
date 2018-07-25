<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/25/2018
 * Time: 6:54 AM
 */

namespace App\Service;


use App\Order;
use Illuminate\Support\Str;
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
        $order['order_code'] = 'DH'. Str::uuid();
        $order['title'] = 'Dơn hàng số 2';
        return $order;
    }

    // public function beforeUpdate($employee, $data){

    // }

    public function update($id, array $data)
    {
        try {
            DB::beginTransaction();
            $updated = $this->model->find($id);
            if (method_exists($this, 'beforeUpdate')) {
                $data = $this->beforeUpdate($updated, $data);
            }
            $updated->update($data);
            if(method_exists($this, 'afterSave')) {
                $this->afterSave($updated, $data, true);
            }
            DB::commit();
            return $this->getById($id);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function afterSave($order, $data, $update = true) {
        if($data['product'] != false) {
            $order->products()->sync($data['product']);
        }
    }
}
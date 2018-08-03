<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/12/2018
 * Time: 12:58 AM
 */

namespace App\Service;


use App\Shop;

class ShopService extends BaseService
{
    protected $selectable = [
        'id',
        'name',
        'description',
        'address',
        'phone',
        'zone',
        'province_code',
        'district_code',
        'ward_code',
        'customer_id'
    ];

    public function __construct(Shop $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }
    protected function selectable(){
        return $this->model->select($this->selectable)->with(['customer'=> function($query) {
            $query->with(['user']);
        }]);
    }
}
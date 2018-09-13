<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/12/2018
 * Time: 12:58 AM
 */

namespace App\Service;


use App\Customer;
use App\Helper\RoleConstant;
use App\Shop;
use Illuminate\Support\Facades\Auth;

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

    public function getAll($selectable = false)
    {
        if (Auth::user()->role_id == 2) {
            return $this->model->select($this->selectable)->where('customer_id', $this->getCustomerId())->get();
        }
        return $this->selectable()->get();
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
    public function __construct(Shop $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function toDto($selectable = null){
        return is_callable($selectable) ? $selectable() : $this->selectable();
    }
    protected function selectable() {
        return $this->model->select($this->selectable)->with(['customer'=> function($query) {
            $query->with(['user']);
        }]);
    }
}
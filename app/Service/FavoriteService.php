<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/27/2018
 * Time: 1:16 AM
 */

namespace App\Service;


use App\Customer;
use App\Favorite;
use App\Helper\RoleConstant;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    private $model;

    public function __construct(Favorite $model)
    {
        $this->model = $model;
    }

    public function index(){
        try {
            return $this->model->where('customer_id', '=', $this->getCustomerId())->get();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store ($data) {
        try {
            $favorite = $this->model->create($data);
            return $favorite;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function update($data, $id = null) {
        try {
            $this->model->where([
                ['customer_id', '=', $this->getCustomerId()],
                ['product_id', '=', $id]
            ])->update($data);
            return $this->getByProductId($id);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function destroy($id) {
        try {
            $cart = $this->model->where([
                ['customer_id', '=', $this->getCustomerId()],
                ['product_id', '=', $id]
            ])->delete();
            return $cart;
        } catch (\Exception $e) {
            return $e;
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

    private function getByProductId ($product_id) {
        return  $this->model->where([
            ['customer_id', '=', $this->getCustomerId()],
            ['product_id', '=', $product_id]
        ])->firstOrFail();
    }
}
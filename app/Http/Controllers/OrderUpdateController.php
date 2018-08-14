<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/14/2018
 * Time: 6:28 AM
 */

namespace App\Http\Controllers;


use App\ProductOrder;
use Illuminate\Support\Facades\Request;

class OrderUpdateController extends Controller
{
    private $model;

    public function __construct(ProductOrder $model)
    {
        $this->model = $model;
    }

    public function show($id){
        try {
            $productOrder = $this->model->where('order_id', '=', $id)->get();
            return $this->api_success_response( ['data' => $productOrder ]);
        } catch (\Exception $e) {
            return $this->api_error_response( $e);
        }
    }

    public function store (Request $request) {
        try {
            $cart = new ProductOrder;
            $cart->create($request->all());
            return $this->api_success_response( ['data' => $this->getByProductId($request->get('product_id'), $request->get('order_id'))]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function update(Request $request, $id) {
        try {
            $action = $request->get('action');
            $product_id = $request->get('product_id');
            if ($action == 'update') {
                $this->model->where([
                    ['order_id', '=', $id],
                    ['product_id', '=', $product_id]
                ])->update(['quantity' => $request->get('quantity')]);
                return $this->api_success_response(['data' => $this->getByProductId($product_id, $id)]);
            } elseif ($action == 'delete') {
                return $this->destroy($id, $product_id);
            }
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    private function destroy($order_id, $product_id) {
        try {
            $cart = $this->model->where([
                ['order_id', '=', $order_id],
                ['product_id', '=', $product_id]
            ])->delete();
            return $this->api_success_response(['data' => $cart]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }


    private function getByProductId ($product_id, $order_id) {
        return  $this->model->where([
            ['order_id', '=', $order_id],
            ['product_id', '=', $product_id]
        ])->firstOrFail();
    }
}
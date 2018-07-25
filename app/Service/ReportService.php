<?php

namespace App\Service;

use App\ProductOrder;
use App\Order;
use App\Product;

class ReportService
{
    protected $selectable = [
        'id',
        'product_code',
        'name',
        'description',
        'unit',
        'price',
        'discount_price',
        'featured_image',
        'category_id',
        'provider_id'
    ];

    public function __construct(ProductOrder $productOrderModel, Order $orderModel, Product $productModel)
    {
        $this->productOrderModel = $productOrderModel;
        $this->orderModel = $orderModel;
        $this->productModel = $productModel;
    }


    public function getCustomerRevenue($params) {
        // return $this->orderModel::where('status', 1)
        //     ->where('customer_id', $params['customer_id'])
            // ->with(['order_product' => function ($query) {
            //     $query->select([
            //         'product_id'
            //     ]);
            // }])
            // ->get();
        // $order_product = $this->productOrderModel::all();
        // return $this->productOrderModel->orders()->get();
        return $this->productModel->with(['order_product' => function ($query) {
            $query->select([
                'product_id'
            ]);
        }])
        ->get();
        
    }
}

<?php

namespace App\Service;

use App\ProductOrder;
use App\Order;
use App\Product;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function __construct(ProductOrder $productOrderModel, Order $orderModel, Product $productModel)
    {
        $this->productOrderModel = $productOrderModel;
        $this->orderModel = $orderModel;
        $this->productModel = $productModel;
    }


    public function getCustomerRevenue($params) {
        return DB::table('orders')
            ->select(
                'order_product.product_id',
                'products.name as product_name',
                DB::raw('SUM(order_product.quantity) as quantity_total'),
                DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total')
            )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->where('customer_id', $params['customer_id'])
            ->where('orders.status', 1)
            ->whereBetween('orders.updated_at', [
                strtotime($params['start_date'] . " 00:00:00"),
                strtotime($params['end_date'] . ' 23:59:59')
            ])
            ->groupBy('order_product.product_id', 'products.name')
            ->get();
    }

    public function getEmployeeRevenue($params) {
        return DB::table('orders')
            ->select(
                'customers.id',
                DB::raw('CONCAT(users.last_name, " ", users.first_name) as name'),
                DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total')
            )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('employees', 'employees.id', '=', 'customers.employee_id')
            ->join('users', 'users.id', '=', 'customers.user_id')
            ->where('customers.employee_id', $params['employee_id'])
            ->where('orders.status', 1)
            ->whereBetween('orders.updated_at', [
                strtotime($params['start_date'] . " 00:00:00"),
                strtotime($params['end_date'] . ' 23:59:59')
            ])
            ->groupBy('orders.customer_id', 'customers.id', 'users.first_name', 'users.last_name')
            ->get();
    }

    public function getNoneOrderCustomers() {
        $ordersUnder4Days = DB::table('orders')
            ->select(
                DB::raw('DISTINCT customer_id')
            )
            ->whereRaw('DATEDIFF(CURRENT_DATE, FROM_UNIXTIME(orders.created_at)) < 4')
            ->get()->map(function($item) {
                return $item->customer_id;
            });

        $customerIds = DB::table('orders')->select('customer_id')
            ->whereNotIn('customer_id', $ordersUnder4Days)
            ->groupBy('customer_id')
            ->get()->map(function($item) {
                return $item->customer_id;
            });

        $customers = DB::table('customers')
            ->select(
                'customers.id',
                DB::raw('CONCAT(customer_user.last_name, " ", customer_user.first_name) as customer_name'),
                'customers.employee_id',
                DB::raw('CONCAT(employee_user.last_name, " ", employee_user.first_name) as employee_name')
            )
            ->whereIn('customers.id', $customerIds)
            ->join('users as customer_user', 'customer_user.id', '=', 'customers.user_id')
            ->join('employees', 'employees.id', '=', 'customers.employee_id')
            ->join('users as employee_user', 'employee_user.id', '=', 'employees.user_id')
            ->get();

        return $customers;
    }
}

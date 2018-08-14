<?php

namespace App\Service;

use App\ProductOrder;
use App\Order;
use App\Product;
use Illuminate\Support\Facades\DB;
use App\Helper\DateTimeHelper;

class ReportService
{
    public function __construct(ProductOrder $productOrderModel, Order $orderModel, Product $productModel)
    {
        $this->productOrderModel = $productOrderModel;
        $this->orderModel = $orderModel;
        $this->productModel = $productModel;
    }

    public function getRevenuesByMonth($month)
    {
        $revenues = DB::table('orders')
            ->select(
                DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%d-%m-%Y") as day'),
                DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total')
            )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.status', 0)
            ->whereRaw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%m-%Y")', $month)
            ->groupBy('day')
            ->get();
        
        $firstDay = '01-'.$month;
        $endDay = date('t-m-Y', strtotime($firstDay));
        $dates = DateTimeHelper::getListDateTime($firstDay, $endDay, 'P1D', 'd-m-Y');

        $results = [];
        foreach ($dates as $date) {
            array_push($results, [
                'day' => $date,
                'revenue' => $this->getRevenueByEachDate($revenues, $date)
            ]);
        }

        return $results;
    }

    public function getRevenuesByYear($year)
    {
        $revenues = DB::table('orders')
            ->select(
                DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%m-%Y") as month'),
                DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total')
            )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.status', 0)
            ->whereRaw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y")', $year)
            ->groupBy('month')
            ->get();

        $results = [];
        for($month = 1; $month <= 12; $month++) {
            $mkMonth = date('m', mktime(0,0,0,$month, 1, date('Y'))) . '-' . $year;
            array_push($results, [
                'month' => $mkMonth,
                'revenue' => $this->getRevenueByEachMonth($revenues, $mkMonth)
            ]);
        }

        return $results;
    }

    public function getCustomerRevenue($params)
    {
        $query = DB::table('orders')
            ->select(
                'order_product.product_id',
                'products.name as product_name',
                'products.quantitative as product_quantitative',
                DB::raw('SUM(order_product.quantity * products.quantitative) as mass_total'),
                DB::raw('SUM(order_product.quantity) as quantity_total'),
                DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total')
            )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_product.product_id');

        if (isset($params['customer_id'])) {
            $query = $query->where('customer_id', $params['customer_id']);
        }

        return $query->where('orders.status', 0)
            ->whereBetween('orders.apply_at', [
                strtotime($params['start_date'] . " 00:00:00"),
                strtotime($params['end_date'] . ' 23:59:59')
            ])
            ->groupBy('order_product.product_id', 'product_name', 'product_quantitative')
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
            ->join('users', 'users.id', '=', 'employees.user_id')
            ->where('customers.employee_id', $params['employee_id'])
            ->where('orders.status', 0)
            ->whereBetween('orders.apply_at', [
                strtotime($params['start_date'] . " 00:00:00"),
                strtotime($params['end_date'] . ' 23:59:59')
            ])
            ->groupBy('orders.customer_id', 'customers.id', 'users.first_name', 'users.last_name')
            ->get();
    }

    public function getNoneOrderCustomers()
    {
        $ordersUnder4Days = DB::table('orders')
            ->select(
                DB::raw('DISTINCT customer_id')
            )
            ->whereRaw('DATEDIFF(CURRENT_DATE, FROM_UNIXTIME(orders.created_at)) < 4')
            ->get()->map(function($item) {
                return $item->customer_id;
            });

        $customers = DB::table('customers')
            ->select(
                'customers.id',
                DB::raw('CONCAT(customer_user.last_name, " ", customer_user.first_name) as customer_name'),
                'customers.employee_id',
                DB::raw('CONCAT(employee_user.last_name, " ", employee_user.first_name) as employee_name'),
                DB::raw('DATE_FORMAT(FROM_UNIXTIME(MAX(orders.created_at)), "%d-%m-%Y %H:%i:%s") as last_order')
            )
            ->whereNotIn('customers.id', $ordersUnder4Days)
            ->join('users as customer_user', 'customer_user.id', '=', 'customers.user_id')
            ->join('employees', 'employees.id', '=', 'customers.employee_id')
            ->join('users as employee_user', 'employee_user.id', '=', 'employees.user_id')
            ->leftJoin('orders', 'orders.customer_id', '=', 'customers.id')
            ->groupBy(
                'customers.id',
                'customer_name',
                'customers.employee_id',
                'employee_name'
            )
            ->get();

        return $customers;
    }

    public function accessStatistical($params)
    {
        $results = [];

        $access_count = DB::table('customers')
            ->select(
                DB::raw('COUNT(user_access_histories.user_id) as access_count'),
                DB::raw('DATE_FORMAT(FROM_UNIXTIME(user_access_histories.created_at), "%d-%m-%Y") as access_day')
            )
            ->join('users', 'users.id', '=', 'customers.user_id')
            ->join('user_access_histories', 'user_access_histories.user_id', '=', 'users.id')
            ->where('customers.id', $params['customer_id'])
            ->whereBetween('user_access_histories.created_at', [
                strtotime($params['start_date'] . " 00:00:00"),
                strtotime($params['end_date'] . ' 23:59:59')
            ])
            ->groupBy('access_day')
            ->get();

        $dates = DateTimeHelper::getListDateTime($params['start_date'], $params['end_date'], 'P1D', 'd-m-Y');
        foreach ($dates as $date) {
            array_push($results, [
                'access_day' => $date,
                'access_count' => $this->getAccessCount($access_count, $date)
            ]);
        }

        return $results;
    }

    public function excellentEmployees()
    {
        return DB::table('orders')
            ->select(
                'employees.id',
                DB::raw('CONCAT(users.last_name, " ", users.first_name) as name'),
                DB::raw('COUNT(orders.id) as order_total'),
                DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total')
            )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('employees', 'employees.id', '=', 'customers.employee_id')
            ->join('users', 'users.id', '=', 'employees.user_id')
            ->where('orders.status', 0)
            ->groupBy('employees.id', 'users.first_name', 'users.last_name')
            ->orderBy('revenue_total', 'desc')
            ->take(5)
            ->get();
    }

    public function soldWellProducts()
    {
        return DB::table('orders')
            ->select(
                'order_product.product_id',
                'products.name as product_name',
                DB::raw('COUNT(orders.id) as order_total'),
                DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total')
            )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->where('orders.status', 0)
            ->groupBy('order_product.product_id', 'products.name')
            ->orderBy('revenue_total', 'desc')
            ->take(5)
            ->get();
    }

    /*================================ PRIVATE FUNCTIONS ================================*/

    private function getAccessCount($access_count, $date)
    {
        foreach ($access_count as $item) {
            if ($item->access_day == $date) return $item->access_count;
        }

        return 0;
    }

    private function getRevenueByEachDate($revenues, $date)
    {
        foreach ($revenues as $item) {
            if ($item->day == $date) return $item->revenue_total;
        }

        return 0;
    }

    private function getRevenueByEachMonth($revenues, $month)
    {
        foreach ($revenues as $item) {
            if ($item->month == $month) return $item->revenue_total;
        }

        return 0;
    }
}

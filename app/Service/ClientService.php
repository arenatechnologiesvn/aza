<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/11/2018
 * Time: 8:55 AM
 */

namespace App\Service;


use App\Customer;
use App\Helper\DateTimeHelper;
use App\Order;
use App\User;
use Carbon\Carbon;
use Faker\Provider\tr_TR\DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

class ClientService
{
    private function getCustomerId(){
        return Customer::where('user_id', '=', Auth::user()->id)->firstOrFail()->id;
    }
    public function staticsToday () {
        return DB::table('orders')
            ->select(
                'products.name as dname',
                DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y-%m-%d") as day'),
                DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total'),
                DB::raw('SUM(order_product.quantity) as quantity')
            )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->where('orders.status', 0)
            ->where('orders.customer_id','=', $this->getCustomerId())
            ->whereRaw(DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y-%m-%d") = "' .Carbon::now()->toDateString() . '"'))
            ->groupBy('products.name', 'day')
            ->get();
    }

    public function staticsByDay ($date) {
        return DB::table('orders')
            ->select(
                'products.name as dname',
                DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y-%m-%d") as ddname'),
                DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total'),
                DB::raw('SUM(order_product.quantity) as quantity')
            )
            ->join('order_product', 'order_product.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->where('orders.status', 0)
            ->where('orders.customer_id','=', $this->getCustomerId())
            ->whereRaw(DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y-%m-%d") = "' . $date . '"'))
            ->groupBy('dname', 'ddname')
            ->get();
    }

    public function staticsByMonth ($month) {
        try {
            $values = DB::table('orders')
                ->select(
                    DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y-%m-%d") as dname'),
                    DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total'),
                    DB::raw('SUM(order_product.quantity) as quantity')
                )
                ->join('order_product', 'order_product.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_product.product_id')
                ->where('orders.status', 0)
                ->where('orders.customer_id','=', $this->getCustomerId())
                ->whereRaw(DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y-%m") = "' . $month . '"'))
                ->groupBy('dname')
                ->get();
            $start = $month . '-01';
            $endDay = date('Y-m-t', strtotime($start));
            $dates = DateTimeHelper::getListDateTime($start, $endDay, 'P1D', 'Y-m-d');
            $result = [];
            foreach ($dates as $date) {
                $tmp = $this->single($values, $date);
                array_push($result, [
                    'dname' => $date,
                    'revenue_total' => $tmp->revenue_total,
                    'quantity' => $tmp->quantity
                ]);
            }
            return $result;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function staticsByYear ($year) {
        try {
            $values = DB::table('orders')
                ->select(
                    DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y-%m") as dname'),
                    DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total'),
                    DB::raw('SUM(order_product.quantity) as quantity')
                )
                ->join('order_product', 'order_product.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_product.product_id')
                ->where('orders.status', 0)
                ->where('orders.customer_id','=', $this->getCustomerId())
                ->whereRaw(DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y") = "' . $year . '"'))
                ->groupBy('dname')
                ->get();
            $result = [];
            for ($i = 1; $i <= 12 ; $i++) {
                $j = $i;
                if ($i < 10) {
                    $j = '0'.$i;
                }
                $tmp = $this->single($values, $year . '-' . $j);
                array_push($result, [
                    'dname' => $year . '-' . $j,
                    'revenue_total' => $tmp->revenue_total,
                    'quantity' => $tmp->quantity
                ]);
            }
            return $result;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function productsInRange($from, $to){
        try {
            return DB::table('orders')
                ->select(
                    'products.name as pname',
                    'products.unit as unit',
                    'products.price as price',
                    'products.quantitative as quantitative',
                    DB::raw('SUM(order_product.quantity * order_product.real_price) as revenue_total'),
                    DB::raw('SUM(order_product.quantity) as quantity')
                )
                ->join('order_product', 'order_product.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_product.product_id')
                ->where('orders.status', 0)
                ->where('orders.customer_id','=', $this->getCustomerId())
                ->whereRaw(DB::raw('DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y-%m-%d") >= "' . $from . '"
                    AND DATE_FORMAT(FROM_UNIXTIME(orders.apply_at), "%Y-%m-%d") <= "' . $to . '"
                '))
                ->groupBy('pname', 'unit', 'price', 'quantitative')
                ->get();
        } catch (\Exception $e) {
            return $e;
        }
    }
    private function single ($arr, $date) {
        foreach ($arr as $item) {
            if($item->dname == $date) return $item;
        }
        return (object) [
            'revenue_total' => 0,
            'quantity' => 0
        ];
    }
}
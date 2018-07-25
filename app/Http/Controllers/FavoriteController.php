<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/22/2018
 * Time: 9:20 AM
 */

namespace App\Http\Controllers;


use App\Customer;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index(){
        $customer = $this->customer->where('user_id', Auth::user()->id)->firstOrFail();
        $favorites = isset($customer->favorites) ? json_decode($customer->favorites, true) : [] ;
        return $favorites ? $this->api_success_response( array_values($favorites)) : $this->api_success_response('');
    }

    public function store (Request $request) {
        $product_id = $request->get('product_id');
        $customer = $this->customer->where('user_id', Auth::user()->id)->firstOrFail();
        $favorites = isset($customer->favorites) ? json_decode($customer->favorites, true) : [] ;
        $favorites[] = $product_id;
        $customer->favorites = json_encode($favorites);
        $customer->save();
        return $this->api_success_response($favorites);
    }

    public function update(Request $request, $id = null) {
        $customer = $this->customer->where('user_id', Auth::user()->id)->firstOrFail();
        $favorites = isset($customer->favorites) ? json_decode($customer->favorites, true) : [] ;
        if (($key = array_search($id, $favorites)) !== false){
            unset($favorites[$key]);
            $customer->favorites = json_encode($favorites);
            $customer->save();
        }
        return $this->api_success_response($favorites);
    }
}
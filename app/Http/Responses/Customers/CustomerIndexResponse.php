<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/24/2018
 * Time: 5:18 AM
 */

namespace App\Http\Responses\Customers;


use App\Customer;
use Illuminate\Contracts\Support\Responsable;

class CustomerIndexResponse implements Responsable
{

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json($this->toDto(), 200);
        // TODO: Implement toResponse() method.

    }

    private function toDto() {
        return Customer::all()->map(function($item) {
            return [
                'id' => $item->id,
                'code' => $item->code,
                'email' => $item->user->email,
                'name' => $item->user->name,
                'type' => $item->customer_type,
                'role_id' => $item->user->role->id,
                'avatar' => $item->user->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower($item->user->email)) . '.jpg?s=200&d=mm',
                'phone' => $item->user->phone,
                'full_name' => $item->user->first_name . ' ' . $item->user->last_name,
                'first_name' => $item->user->first_name,
                'last_name' => $item->user->last_name
            ];
        });
    }
}
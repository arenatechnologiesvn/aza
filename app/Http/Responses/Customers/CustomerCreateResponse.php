<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/24/2018
 * Time: 5:19 AM
 */

namespace App\Http\Responses\Customers;


use App\Customer;
use App\Dto\CustomerDto;
use App\Helper\ApiResponse;
use App\Http\Responses\FailedResponse;
use App\User;
use Illuminate\Contracts\Support\Responsable;

class CustomerCreateResponse implements Responsable
{

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        // TODO: Implement toResponse() method.
        try {
            $customer = $this->saveCustomer($request->all());
            return  $customer ? response()->json(new ApiResponse('Create Customer successful', CustomerDto::toDto($customer), 200)) : new FailedResponse();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function saveCustomer(array $data) {
        try {
            $user = User::create([
                'name' => $data['name'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'role_id' => 2,
                'password' => bcrypt($data['password']),
                'phone' => $data['phone']
            ]);
            if ($user) {
                return Customer::create([
                    'user_id' => $user->id,
                    'code' => $data['code'],
                    'customer_type' => $data['customer_type'],
                    'address' => $data['address'],
                    'province_code' => $data['selectedProvince']['selectedProvince'],
                    'district_code' => $data['selectedProvince']['selectedDistrict'],
                    'ward_code' => $data['selectedProvince']['selectedWard'],
                    'employee_id' => $data['employee_id']
                ]);
            } else {
                return false;
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
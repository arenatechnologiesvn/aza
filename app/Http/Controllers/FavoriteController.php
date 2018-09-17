<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/22/2018
 * Time: 9:20 AM
 */

namespace App\Http\Controllers;


use App\Customer;


use App\Favorite;
use App\Service\FavoriteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helper\RoleConstant;

class FavoriteController extends Controller
{
    private $service;

    public function __construct(FavoriteService $service)
    {
        $this->service = $service;
    }

    public function index(){
        try {
            return $this->api_success_response( ['data' => $this->service->index() ]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function store (Request $request) {
        try {
            return $this->api_success_response( ['data' => $this->service->store($request->all())]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function update(Request $request, $id = null) {
        try {
            return $this->api_success_response(['data' => $this->service->update($request->all(), $id)]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

    public function destroy($id) {
        try {
            return $this->api_success_response(['data' => $this->service->destroy($id)]);
        } catch (\Exception $e) {
            return $this->api_error_response($e);
        }
    }

}
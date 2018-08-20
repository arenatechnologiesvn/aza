<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/20/2018
 * Time: 10:21 PM
 */

namespace App\Http\Controllers;


use App\Service\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function getPopup($key) {
        try {
            return $this->api_success_response(['data' => $this->service->action('get', $key)]) ;
        } catch(\Exception $e){
            return $this->api_error_response($e);
        }
    }

    public function createPopup(Request $request, $key) {
        try {
            return $this->api_success_response(['data' => $this->service->action('post', $key, $request->all())]) ;
        } catch(\Exception $e){
            return $this->api_error_response($e);
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/11/2018
 * Time: 9:13 AM
 */

namespace App\Http\Controllers;


use App\Service\ClientService;

class ClientController extends Controller
{
    private $service;
    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function staticsToday () {
        return $this->api_success_response(['data' => $this->service->staticsToday()]);
    }

    public function staticsByDay ($date) {
        return $this->api_success_response(['data' => $this->service->staticsByDay($date)]);
    }

    public function staticsByMonth ($month) {
        return $this->api_success_response(['data' => $this->service->staticsByMonth($month)]);
    }

    public function staticsByYear ($year) {
        return $this->api_success_response(['data' => $this->service->staticsByYear($year)]);
    }
}
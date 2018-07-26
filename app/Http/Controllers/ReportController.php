<?php

namespace App\Http\Controllers;

use App\Service\ReportService;
use App\Http\Requests\Report\StoreCustomerRevenue;
use App\Http\Requests\Report\StoreEmployeeRevenue;

class ReportController extends Controller
{
    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function getCustomerRevenue(StoreCustomerRevenue $request)
    {
        $revenues = $this->service->getCustomerRevenue($request);
        return $this->api_success_response(['data' => $revenues]);
    }

    public function getEmployeeRevenue(StoreEmployeeRevenue $request)
    {
        $revenues = $this->service->getEmployeeRevenue($request);
        return $this->api_success_response(['data' => $revenues]);
    }

    public function getNoneOrderCustomers()
    {
        $customers = $this->service->getNoneOrderCustomers();
        return $this->api_success_response(['data' => $customers]);
    }

    public function accessStatistical(StoreCustomerRevenue $request)
    {
        $statisticals = $this->service->accessStatistical($request);
        return $this->api_success_response(['data' => $statisticals]);
    }
}
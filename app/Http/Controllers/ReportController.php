<?php

namespace App\Http\Controllers;

use App\Service\ReportService;
use App\Http\Requests\Report\StoreCustomerRevenue;
use App\Http\Requests\Report\StoreEmployeeRevenue;
use App\Http\Requests\Report\StoreRevenue;

class ReportController extends Controller
{
    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function getRevenues(StoreRevenue $request)
    {
        $revenues = [];
        if ($request->type == 'month') {
            $revenues = $this->service->getRevenuesByMonth($request->month);
        } else {
            $revenues = $this->service->getRevenuesByYear($request->year);
        }

        return $this->api_success_response(['data' => $revenues]);
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

    public function excellentEmployees()
    {
        $employees = $this->service->excellentEmployees();
        return $this->api_success_response(['data' => $employees]);
    }

    public function soldWellProducts()
    {
        $products = $this->service->soldWellProducts();
        return $this->api_success_response(['data' => $products]);
    }

    public function getSellingProducts(StoreCustomerRevenue $request)
    {
        $products = $this->service->getSellingProducts($request);
        return $this->api_success_response(['data' => $products]);
    }
}
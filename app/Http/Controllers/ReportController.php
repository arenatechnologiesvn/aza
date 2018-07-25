<?php

namespace App\Http\Controllers;

use App\Service\ReportService;
use App\Http\Requests\Report\StoreCustomerRevenue;

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
}
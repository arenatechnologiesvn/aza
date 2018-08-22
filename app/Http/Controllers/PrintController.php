<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/21/2018
 * Time: 9:32 PM
 */

namespace App\Http\Controllers;


use App\Service\OrderService;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

class PrintController extends Controller
{
    private $pdf;
    private $service;
    public function __construct(PDF $pdf, OrderService $service)
    {
        $this->pdf = $pdf;
        $this->service = $service;
    }

    public function index(){
        $p = $this->pdf->loadView('pdf.bill', ['key' => 'Content']);
        return $p;
    }
    public function show($id){
//        return $this->api_success_response(['data' => 'd' ]);
//        return view("pdf.bill")->with("order", $this->service->getById($id));
//        return App::view('pdf.bill', ['order' =>]);
        $order = $this->pdf->loadView('pdf.bill', ['order' =>$this->service->getById($id)]);
        return $order->stream();
//        return $order->download('bill.pdf');
    }
}
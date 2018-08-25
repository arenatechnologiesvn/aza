<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/21/2018
 * Time: 9:32 PM
 */

namespace App\Http\Controllers;


use App\Service\OrderService;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
class PrintController extends Controller
{
    private $service;
    public function __construct(OrderService $service)
    {
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
//        $order = $this->pdf->loadView('pdf.bill', ['order' =>$this->service->getById($id)]);
//        return $order->stream();
        try {
            $connector = new FilePrintConnector("php://stdout");
            $printer = new Printer($connector);
            $printer -> text("Hello World!\n");
            $printer -> cut();
            $printer -> close();
            return $this->api_success_response(['data' => view('pdf.bill', ['order' =>$this->service->getById($id)])->render()]) ;
        } catch (\Exception $e) {
        }
//        return $order->download('bill.pdf');
    }
}
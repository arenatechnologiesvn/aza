<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/21/2018
 * Time: 9:32 PM
 */

namespace App\Http\Controllers;


use App\Service\OrderService;
use App\Service\SettingService;
use App\Setting;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
class PrintController extends Controller
{
    private $service;
    private $settings;
    public function __construct(OrderService $service, SettingService $setting)
    {
        $this->service = $service;
        $this->settings = $setting;
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
            return $this->api_success_response(['data' => view('pdf.bill', ['order' =>$this->service->getById($id), 'settings' => $this->settings->all()])->render(), 'settings' => $this->settings->all()]) ;
        } catch (\Exception $e) {
        }
//        return $order->download('bill.pdf');
    }
}
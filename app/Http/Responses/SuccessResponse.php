<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/10/2018
 * Time: 12:19 AM
 */

namespace App\Http\Responses;

use App\Helper\ApiResponse;
use Illuminate\Contracts\Support\Responsable;

class SuccessResponse implements Responsable
{
    protected $data;
    protected $dto;
    protected $message;

    public function __construct($data, $message)
    {
        $this->data = $data;
//        $this->dto = $dto;
        $this->message = $message;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        // TODO: Implement toResponse() method.
        return response()->json(new ApiResponse($this->message, $this->data, 200));
    }

//    private function processData() {
//        if (count($this->data) > 1){
//            return $this->dto->toListDto($this->data);
//        } else {
//            return $this->dto->toDto($this->data);
//        }
//    }
}
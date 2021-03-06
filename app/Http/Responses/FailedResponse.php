<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/15/2018
 * Time: 10:35 PM
 */

namespace App\Http\Responses;


use Illuminate\Contracts\Support\Responsable;

class FailedResponse implements Responsable
{
    protected $code;
    protected $message;

    public function __construct($code, $message)
    {
        $this->code = $code;
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
        return response()->json(['message' => $this->message], $this->code);
    }
}

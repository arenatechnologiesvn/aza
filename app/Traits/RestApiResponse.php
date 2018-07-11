<?php
namespace App\Traits;

trait RestApiResponse
{
    public function api_success_response($data = []) {
        return response()->json([
            "success" => true,
            "data"    => $data
        ], 200);
    }

    public function api_error_response($message = null, $error = null) {
        return response()->json([
            "success" => false,
            "message" => $message,
            "error"   => $error
        ], 200);
    }
}
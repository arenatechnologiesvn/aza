<?php
namespace App\Traits;

define("FILE_NOT_FOUND_ERROR_MESSAGE", "Lỗi hệ thống (File Not Found)");
define("INTERNAL_SERVER_ERROR_MESSAGE", "Lỗi hệ thống");

define("AUTH_ACCOUNT_VERIFY_ERROR_MESSAGE", "Tài khoản chưa kích hoạt. Làm ơn liên hệ AZA để được kích hoạt");
define("AUTH_ACCOUNT_LOCK_ERROR_MESSAGE", "Tài khoản đã bị tạm khóa");
define("AUTH_ACCOUNT_NOT_EXIST_ERROR_MESSAGE", "Tài khoản không tồn tại");
define("AUTH_LOGIN_ERROR_MESSAGE", "Email hoặc mật khẩu không đúng");
define("AUTH_ALREADY_LOGIN_ERROR_MESSAGE", "Tài khoản đã được đăng nhập");
define("AUTH_JWT_EXPIRE_ERROR_MESSAGE", "Phiên đăng nhập đã kết thúc. Làm ơn đăng nhập lại");
define("AUTH_JWT_INVALID_ERROR_MESSAGE", "Đăng nhập không hợp lệ");

define("ORDER_BILL_PRINTING_ERROR_MESSAGE", "In hóa đơn thất bại");

define("RECORD_CREATE_ERROR_MESSAGE", "Tạo mới thất bại");
define("RECORD_UPDATE_ERROR_MESSAGE", "Cập nhật thất bại");
define("RECORD_DELETE_ERROR_MESSAGE", "Xóa thất bại");

define("PARAM_VALIDATE_ERROR_MESSAGE", "Dữ liệu không hợp lệ");

trait RestApiResponse
{
    public function api_success_response($data = []) {
        return response()->json([
            "success" => true,
            "data"    => $data
        ], 200);
    }

    public function api_error_response($message = null, $mobile_message = null, $error = null) {
        return response()->json([
            "success" => false,
            "message" => $message,
            "mobile_message" => isset($mobile_message) ? $mobile_message : INTERNAL_SERVER_ERROR_MESSAGE,
            "error" => $error
        ], 200);
    }
}
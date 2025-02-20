<?php
require_once '../../config/cors.php';
require_once '../../controllers/AuthController.php';

$authController = new AuthController();

function sendResponse($status, $success, $message, $data = null)
{
    http_response_code($status);
    $response = ["success" => $success, "message" => $message];
    if ($data) {
        $response["data"] = $data;
    }
    echo json_encode($response);
}

try {
    // Xử lý yêu cầu OPTIONS
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        sendResponse(200, true, "CORS preflight response");
        return;
    }

    // Kiểm tra phương thức yêu cầu
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse(405, false, "Phương thức không được phép");
        return;
    }

    // Lấy dữ liệu từ yêu cầu
    $data = json_decode(file_get_contents("php://input"));

    // Kiểm tra dữ liệu đầu vào
    if (empty($data->email) || empty($data->password)) {
        sendResponse(400, false, "Thiếu thông tin đăng nhập.");
        return;
    }

    // Gọi phương thức đăng nhập
    $response = $authController->login($data);

    // Kiểm tra kết quả đăng nhập
    if (!$response) {
        sendResponse(401, false, "Thông tin đăng nhập không chính xác.");
        return;
    }

    // Gửi phản hồi thành công
    sendResponse(200, true, "Đăng nhập thành công", $response);
} catch (Exception $e) {
    // Xử lý lỗi server
    sendResponse(500, false, "Lỗi server: " . $e->getMessage());
}

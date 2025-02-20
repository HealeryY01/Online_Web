<?php
require_once '../../config/cors.php';
require_once '../../controllers/UserController.php';

$userController = new UserController();

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
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        sendResponse(200, true, "CORS preflight response");
        return;
    }
    // Kiểm tra phương thức yêu cầu
    if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
        sendResponse(405, false, "Phương thức không được phép");
        return;
    }

    // Lấy dữ liệu từ yêu cầu
    $data = json_decode(file_get_contents("php://input"));

    // Kiểm tra dữ liệu đầu vào
    if (empty($data->user_id) || empty($data->email) || empty($data->name)) {
        sendResponse(400, false, "Thiếu thông tin cần thiết.");
        return;
    }

    // Gọi phương thức cập nhật người dùng
    $result = $userController->updateUser($data->user_id, $data->email, $data->name);

    // Kiểm tra kết quả cập nhật
    if (!$result) {
        sendResponse(404, false, "Người d��ng không tồn tại hoặc không thể cập nhật.");
        return;
    }

    // Gửi phản hồi thành công
    sendResponse(200, true, "Cập nhật người dùng thành công.");
} catch (Exception $e) {
    // Xử lý lỗi server
    sendResponse(500, false, "Lỗi server: " . $e->getMessage());
}
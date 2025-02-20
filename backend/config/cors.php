<?php
// Đặt các header cho phép CORS
header("Access-Control-Allow-Origin: http://localhost:2001"); // Chỉ cho phép từ frontend
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Các phương thức được phép
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Các header được phép
header("Access-Control-Allow-Credentials: true"); // Nếu sử dụng cookies

// Đảm bảo phản hồi các yêu cầu preflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

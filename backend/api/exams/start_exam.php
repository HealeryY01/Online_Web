<?php
require_once __DIR__ . '/../../config/database.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->exam_id)) {
        $database = new Database();
        $conn = $database->getConnection();

        // Giả sử bạn có một cột 'status' trong bảng exams để theo dõi trạng thái kỳ thi
        $query = "UPDATE exams SET status = 'started' WHERE id = :exam_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':exam_id', $data->exam_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Kỳ thi đã bắt đầu."]);
        } else {
            echo json_encode(["success" => false, "message" => "Lỗi khi bắt đầu kỳ thi."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Phương thức không hợp lệ."]);
}
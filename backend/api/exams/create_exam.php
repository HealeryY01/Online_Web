<?php
require_once __DIR__ . '/../../config/database.php';
require_once '../../config/cors.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->name) && isset($data->start_date) && isset($data->end_date)) {
        $database = new Database();
        $conn = $database->getConnection();

        $query = "INSERT INTO exams (name, start_date, end_date) VALUES (:name, :start_date, :end_date)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':name', $data->name);
        $stmt->bindParam(':start_date', $data->start_date);
        $stmt->bindParam(':end_date', $data->end_date);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Kỳ thi đã được tạo thành công."]);
        } else {
            echo json_encode(["success" => false, "message" => "Lỗi khi tạo kỳ thi."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Phương thức không hợp lệ."]);
}

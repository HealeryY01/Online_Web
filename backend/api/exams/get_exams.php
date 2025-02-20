<?php
require_once __DIR__ . '/../../config/database.php';
require_once '../../config/cors.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT id, name, start_date, end_date FROM exams";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($exams) {
        echo json_encode(["success" => true, "data" => $exams]);
    } else {
        echo json_encode(["success" => false, "message" => "Không tìm thấy kỳ thi."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Phương thức không hợp lệ."]);
}

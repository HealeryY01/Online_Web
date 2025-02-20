<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../models/Exam.php');

class ExamController
{
    private $db;
    private $exam;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->exam = new Exam($this->db);
    }

    public function createExam($data)
    {
        if (empty($data->name) || empty($data->start_date) || empty($data->end_date)) {
            throw new Exception("Vui lòng điền đầy đủ thông tin kỳ thi");
        }

        $examData = [
            'name' => $data->name,
            'start_date' => $data->start_date,
            'end_date' => $data->end_date,
        ];

        if ($this->exam->create($examData)) {
            return ["success" => true, "message" => "Kỳ thi đã được tạo thành công."];
        } else {
            throw new Exception("Không thể tạo kỳ thi");
        }
    }

    public function startExam($data)
    {
        if (empty($data->exam_id)) {
            throw new Exception("Thiếu ID kỳ thi");
        }

        if ($this->exam->start($data->exam_id)) {
            return ["success" => true, "message" => "Kỳ thi đã bắt đầu."];
        } else {
            throw new Exception("Không thể bắt đầu kỳ thi");
        }
    }

    public function getExams()
    {
        return $this->exam->getAllExams();
    }
}
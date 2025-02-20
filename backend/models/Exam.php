<?php
class Exam
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($examData)
    {
        $query = "INSERT INTO exams (name, start_date, end_date) VALUES (:name, :start_date, :end_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $examData['name']);
        $stmt->bindParam(':start_date', $examData['start_date']);
        $stmt->bindParam(':end_date', $examData['end_date']);
        return $stmt->execute();
    }

    public function start($examId)
    {
        $query = "UPDATE exams SET status = 'started' WHERE id = :exam_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':exam_id', $examId);
        return $stmt->execute();
    }

    public function getAllExams()
    {
        $query = "SELECT id, name, start_date, end_date FROM exams";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
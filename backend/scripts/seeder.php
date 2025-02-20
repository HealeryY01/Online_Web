<?php
require_once __DIR__ . '/../config/database.php';

class Seeder
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function seed()
    {
        $this->seedUsers();
        $this->seedContacts();
        $this->seedExams();
    }

    private function seedUsers()
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name' => 'Administrator',
                'role' => 'admin',
                'phone' => '0123456789',
                'address' => 'Hà Nội',
                'avatar' => 'default-avatar.png',
                'status' => 'active',
            ],
            [
                'username' => 'teacher1',
                'email' => 'teacher1@example.com',
                'password' => password_hash('teacher123', PASSWORD_DEFAULT),
                'full_name' => 'Giáo viên 1',
                'role' => 'teacher',
                'phone' => '0123456788',
                'address' => 'Hà Nội',
                'avatar' => 'default-avatar.png',
                'status' => 'active',
            ],
            [
                'username' => 'student1',
                'email' => 'student1@example.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'full_name' => 'Học sinh 1',
                'role' => 'student',
                'phone' => '0123456787',
                'address' => 'Hà Nội',
                'avatar' => 'default-avatar.png',
                'status' => 'active',
            ],
        ];

        $query = "INSERT INTO users (username, email, password, full_name, role, phone, address, avatar, status) VALUES (:username, :email, :password, :full_name, :role, :phone, :address, :avatar, :status)";
        $stmt = $this->conn->prepare($query);

        foreach ($users as $user) {
            $stmt->execute([
                ':username' => $user['username'],
                ':email' => $user['email'],
                ':password' => $user['password'],
                ':full_name' => $user['full_name'],
                ':role' => $user['role'],
                ':phone' => $user['phone'],
                ':address' => $user['address'],
                ':avatar' => $user['avatar'],
                ':status' => $user['status'],
            ]);
            echo "Đã thêm người dùng: " . $user['full_name'] . "\n";
        }
    }

    private function seedContacts()
    {
        $contacts = [
            [
                'name' => 'Nguyễn Văn A',
                'email' => 'nguyenvana@example.com',
                'subject' => 'Hỏi về khóa học',
                'message' => 'Tôi muốn biết thêm thông tin về khóa học.',
            ],
            [
                'name' => 'Trần Thị B',
                'email' => 'tranthib@example.com',
                'subject' => 'Phản hồi',
                'message' => 'Khóa học rất hữu ích, cảm ơn!',
            ],
        ];

        $query = "INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
        $stmt = $this->conn->prepare($query);

        foreach ($contacts as $contact) {
            $stmt->execute([
                ':name' => $contact['name'],
                ':email' => $contact['email'],
                ':subject' => $contact['subject'],
                ':message' => $contact['message'],
            ]);
            echo "Đã thêm liên hệ: " . $contact['name'] . "\n";
        }
    }

    private function seedExams()
    {
        $exams = [
            [
                'name' => 'Kiểm tra giữa kỳ',
                'start_date' => '2023-10-01 09:00:00',
                'end_date' => '2023-10-01 11:00:00',
            ],
            [
                'name' => 'Kiểm tra cuối kỳ',
                'start_date' => '2023-12-15 09:00:00',
                'end_date' => '2023-12-15 11:00:00',
            ],
            [
                'name' => 'Kiểm tra giữa kỳ môn Vật lý',
                'start_date' => '2023-10-10 09:00:00',
                'end_date' => '2023-10-10 11:00:00',
            ],
        ];

        $query = "INSERT INTO exams (name, start_date, end_date) VALUES (:name, :start_date, :end_date)";
        $stmt = $this->conn->prepare($query);

        foreach ($exams as $exam) {
            $stmt->execute([
                ':name' => $exam['name'],
                ':start_date' => $exam['start_date'],
                ':end_date' => $exam['end_date'],
            ]);
            echo "Đã thêm kỳ thi: " . $exam['name'] . "\n";
        }
    }
}

// Khởi tạo kết nối và chạy seeder
try {
    $database = new Database();
    $conn = $database->getConnection();
    $seeder = new Seeder($conn);
    $seeder->seed();
} catch (Exception $e) {
    die("Lỗi kết nối: " . $e->getMessage() . "\n");
}
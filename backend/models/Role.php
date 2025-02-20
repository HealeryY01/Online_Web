<?php
class Role
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllRoles()
    {
        $query = "SELECT id, name FROM roles";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
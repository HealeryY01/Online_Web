<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../models/Role.php');

class RoleController
{
    private $db;
    private $role;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->role = new Role($this->db);
    }

    public function getAllRoles()
    {
        return $this->role->getAllRoles();
    }


    // public function getUserRole($userId)
    // {
    //     require_once(__DIR__ . '/../models/User.php');
    //     $user = new User($this->db);
    //     return $user->getRoleByUserId($userId);
    // }

    // public function updateUserRole($userId, $newRole)
    // {
    //     require_once(__DIR__ . '/../models/User.php');
    //     $user = new User($this->db);
    //     return $user->updateRoleByUserId($userId, $newRole);
    // }
}
<?php


namespace App\Repository;

use App\Config\Database;
use PDO;
use App\Models\User;

class UserRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function save(User $user)
    {
        $sql = "INSERT INTO users(name,phone_number,email,password) VALUES(?,?,?,?)";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            $user->getName(),
            $user->getPhoneNumber(),
            $user->getEmail(),
            $user->getPassword()
        ]);
        $id = $this->db->lastInsertId();
        return $this->findById($id);
    }

    public function findById($id)
    {
        $query = $this->db->prepare("SELECT *FROM users WHERE id=?");
        $query->execute([$id]);

        $result = array();

        while ($row = $query->fetch()) {
            $result = [
                "id" => $row['id'],
                'name' => $row['name'],
                'phone_number' => $row['phone_number'],
                'email' => $row['email'],
            ];
        }
        return $result;
    }

    public function findByEmail($email)
    {
        $query = $this->db->prepare("SELECT *FROM users WHERE email=?");
        $query->execute([$email]);

        $result = array();

        while ($row = $query->fetch()) {
            $result = [
                "id" => $row['id'],
                'name' => $row['name'],
                'phone_number' => $row['phone_number'],
                'email' => $row['email'],
                'password' => $row['password'],
            ];
        }
        return $result;
    }
}
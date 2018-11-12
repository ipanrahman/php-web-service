<?php

class User extends Model
{

    protected $table = "users";

    public function findAll()
    {
        $query = self::getConnection()->prepare("SELECT *FROM users");
        $query->execute();

        $result = array();
        $index = 0;

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[$index++] = [
                "id" => $row['id'],
                "first_name" => $row['first_name'],
                "last_name" => $row['last_name'],
                "email" => $row['email'],
                "phone_number" => $row['phone_number'],
                "created_at" => $row['created_date'],
                "updated_at" => $row['updated_date']
            ];
        }
        return $result;
    }

    public function findById($id)
    {
        $query = self::getConnection()->prepare("SELECT *FROM users WHERE id=?");
        $query->execute([$id]);

        $result = array();

        while ($row = $query->fetch()) {
            $result = [
                "id" => $row['id'],
                "first_name" => $row['first_name'],
                "last_name" => $row['last_name'],
                "email" => $row['email'],
                "phone_number" => $row['phone_number'],
                "created_at" => $row['created_date'],
                "updated_at" => $row['updated_date']
            ];
        }
        return $result;
    }
}
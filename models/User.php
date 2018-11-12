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
                "created_date" => $row['created_date'],
                "updated_date" => $row['updated_date']
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
                "created_date" => $row['created_date'],
                "updated_date" => $row['updated_date']
            ];
        }
        return $result;
    }

    public function save($data)
    {
        $sql = "INSERT INTO users(id,first_name,last_name,email,phone_number,created_date,updated_date) VALUES"
            . "(:id,:first_name,:last_name,:email,:phone_number,now(),now())";

        $connection = self::getConnection();
        $id = $this->randomId();
        $statement = $connection->prepare($sql);
        $statement->execute([
            'id' => $id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number']
        ]);

        return $this->findById($id);
    }

    public function update($data)
    {
        $sql = "UPDATE users SET first_name=:first_name,last_name=:last_name,email=:email,phone_number=:phone_number WHERE id=:id";
        $connection = self::getConnection();
        $id = $data['id'];
        $statement = $connection->prepare($sql);
        $statement->execute([
            'id' => $id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number']
        ]);
        return $this->findById($id);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id=:id";

        $connection = self::getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }
}
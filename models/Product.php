<?php

class Product extends Model
{
    public function findAll()
    {
        $query = self::getConnection()->prepare("SELECT *FROM products");
        $query->execute();

        $result = array();
        $index = 0;

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[$index++] = [
                "id" => $row['id'],
                "name" => $row['name'],
                "price" => $row['price'],
                'photo_url' => $row['photo_url'],
                'user_id' => $row['user_id'],
                "created_date" => $row['created_date'],
                "updated_date" => $row['updated_date']
            ];
        }
        return $result;
    }

    public function findById($id)
    {
        $query = self::getConnection()->prepare("SELECT *FROM products WHERE id=?");
        $query->execute([$id]);

        $result = array();

        while ($row = $query->fetch()) {
            $result = [
                "id" => $row['id'],
                'name' => $row['name'],
                'title' => $row['title'],
                'price' => $row['price'],
                'photo_url' => $row['photo_url'],
                'user_id' => $row['user_id'],
                'created_date' => $row['created_date'],
                'updated_date' => $row['updated_date']
            ];
        }
        return $result;
    }

    public function findByUserId($userId)
    {
        $query = self::getConnection()->prepare("SELECT *FROM products WHERE user_id=?");
        $query->execute([$userId]);

        $result = array();
        $index = 0;
        while ($row = $query->fetch()) {
            $result[$index] = [
                "id" => $row['id'],
                'name' => $row['name'],
                'title' => $row['title'],
                'price' => $row['price'],
                'photo_url' => $row['photo_url'],
                'user_id' => $row['user_id'],
                'created_date' => $row['created_date'],
                'updated_date' => $row['updated_date']
            ];
            $index++;
        }
        return $result;
    }


    public function save($data)
    {
        $sql = "INSERT INTO products(id,name,price,photo_url,user_id,created_date,updated_date) VALUES"
            . "(:id,:name,:price,:photo_url,:user_id,current_timestamp,current_timestamp)";

        $connection = self::getConnection();
        $id = $this->randomId();
        $statement = $connection->prepare($sql);
        $statement->execute([
            'id' => $id,
            'name' => $data['name'],
            'price' => $data['price'],
            'photo_url' => $data['photo_url'],
            'user_id' => $data['user_id']
        ]);

        return $this->findById($id);
    }

    public function update($data)
    {
        $sql = "UPDATE products SET name=:name,price=:price,photo_url=:photo_url,user_id=:user_id,updated_date=current_timestamp WHERE id=:id";
        $connection = self::getConnection();
        $id = $data['id'];
        $statement = $connection->prepare($sql);
        $statement->execute([
            'id' => $id,
            'name' => $data['name'],
            'price' => $data['price'],
            'photo_url' => $data['photo_url'],
            'user_id' => $data['user_id']
        ]);
        return $this->findById($id);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id=:id";

        $connection = self::getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }
}
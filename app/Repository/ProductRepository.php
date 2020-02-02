<?php


namespace App\Repository;

use PDO;
use App\Config\Database;

class ProductRepository
{

    private $db;

    /**
     * ProductRepository constructor.
     */
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll()
    {
        $query = $this->db->prepare("SELECT *FROM products");
        $query->execute();

        $result = array();
        $index = 0;

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[$index++] = [
                "id" => $row['id'],
                "name" => $row['name'],
                "price" => $row['price'],
                'photo_url' => $row['photo_url'],
                'description' => $row['description'],
                "created_date" => $row['created_date'],
                "updated_date" => $row['updated_date']
            ];
        }
        return $result;
    }

    public function findById($id)
    {
        $query = $this->db->prepare("SELECT *FROM products WHERE id=?");
        $query->execute([$id]);

        $result = array();

        while ($row = $query->fetch()) {
            $result = [
                "id" => $row['id'],
                'name' => $row['name'],
                'price' => $row['price'],
                'description' => $row['description'],
                'photo_url' => $row['photo_url'],
                'created_date' => $row['created_date'],
                'updated_date' => $row['updated_date']
            ];
        }
        return $result;
    }

    public function findByUserId($userId)
    {
        $query = $this->db->prepare("SELECT *FROM products WHERE user_id=?");
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
                'created_date' => $row['created_date'],
                'updated_date' => $row['updated_date']
            ];
            $index++;
        }
        return $result;
    }


    public function save($data)
    {
        $sql = "INSERT INTO products(id,name,price,photo_url,description,created_date,updated_date) VALUES"
            . "(:id,:name,:price,:photo_url,:description,current_timestamp,current_timestamp)";

        $id = Database::randomId();
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'id' => $id,
            'name' => $data['name'],
            'price' => $data['price'],
            'photo_url' => $data['photo'],
            'description' => $data['description']
        ]);

        return $this->findById($id);
    }

    public function update($data)
    {
        $sql = "UPDATE products SET name=:name,price=:price,photo_url=:photo_url,description=:description,updated_date=current_timestamp WHERE id=:id";
        $id = $data['id'];
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'id' => $id,
            'name' => $data['name'],
            'price' => $data['price'],
            'photo_url' => $data['photo'],
            'description' => $data['description']
        ]);
        return $this->findById($id);
    }

    public function updateWithoutPhoto($data)
    {
        $sql = "UPDATE products SET name=:name,price=:price,description=:description,updated_date=current_timestamp WHERE id=:id";
        $id = $data['id'];
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'id' => $id,
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description']
        ]);
        return $this->findById($id);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id=:id";

        $statement = $this->db->prepare($sql);
        $statement->execute(['id' => $id]);
    }


}
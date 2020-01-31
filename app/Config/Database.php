<?php


namespace App\Config;

use PDO;

class Database
{
    public static function getConnection()
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=rest_api", "root", "root");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    protected function randomId()
    {
        $connection = self::getConnection();
        $query = $connection->prepare("SELECT uuid() AS id");
        $query->execute();

        $result = $query->fetch();

        return $result['id'];
    }

}
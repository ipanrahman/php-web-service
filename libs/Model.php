<?php

namespace Libs;

use PDO;

abstract class Model
{

    protected static function getConnection()
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=my_crud", "root", "root");
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

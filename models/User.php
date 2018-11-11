<?php

class User extends Model
{
    public static function findAll()
    {
        $query = self::getConnection()->prepare("SELECT *FROM users");
        $query->execute();

        return $query->fetch();
    }
}
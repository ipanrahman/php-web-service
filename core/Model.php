<?php

abstract class Model
{
    protected static function getConnection()
    {
        return new \PDO("mysql:host=localhost;dbname=uts_web_service", "root", "");
    }
}
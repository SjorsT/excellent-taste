<?php

namespace Admin\Database;

use PDO;


class Database
{
    public function __construct()
    {
    }

    static function connect()
    {
        $host =  $_ENV["DB_PORT"];
        $dbName = $_ENV["DB_NAME"];
        $userName = $_ENV["DB_USERNAME"];
        $password = $_ENV["DB_PASSWORD"];
        $db = new PDO("mysql:host=" . $host . ";dbname=" . $dbName, $userName, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    static function executeQuery($query, $values)
    {
        !isset($db) ? $db = \Admin\Database\Database::connect() : NULL;
        $preparedQuery = $db->prepare($query);
        $preparedQuery->execute($values);
    }

    static function getRecords($query, $values)
    {
        !isset($db) ? $db = \Admin\Database\Database::connect() : NULL;
        $preparedQuery = $db->prepare($query);
        if ($preparedQuery->execute($values)) {
            return $preparedQuery->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}

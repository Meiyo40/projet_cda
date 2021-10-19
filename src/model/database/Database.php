<?php


namespace App\model\database;

use PDO;

class Database{
    private static $db_user = 'symfony';
    private static $db_pwd = 'symfony';
    private static $dsn = 'mysql:host=localhost;dbname=simple_crud_api';

    private static $connection_db = null;

    public static function connect(){
        try {
            self::$connection_db = new PDO(self::$dsn, self::$db_user, self::$db_pwd);
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
        return self::$connection_db;
    }

    public static function disconnect(){
        self::$connection_db = null;
    }


}

Database::connect();
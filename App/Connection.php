<?php

namespace App;

use PDOException;

class Connection
{
    const HOST = "localhost";
    const DBNAME = "db_twitter_clone";
    const USERNAME = "root";
    const PASSWORD = "";

    private $conn;

    public static function getDb()
    {
        try 
        {
            $conn = new \PDO(
                "mysql:host=" . Connection::HOST . ";dbname=" . Connection::DBNAME, 
                Connection::USERNAME, Connection::PASSWORD
            );
            
            return $conn;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}
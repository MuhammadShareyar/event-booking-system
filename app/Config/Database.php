<?php

namespace App\Config;

use Dotenv\Dotenv;
use Exception;
use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private ?PDO $connection = null;

    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../..");
        $dotenv->load();

        $host = $_ENV["DB_HOST"];
        $dbname = $_ENV["DB_NAME"];
        $username = $_ENV["DB_USER"];
        $password = $_ENV["DB_PASSWORD"];

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function connect()
    {
        if (self::$instance == null) {
            self::$instance = new Self();
        }

        return self::$instance->connection;
    }
}

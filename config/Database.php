<?php

namespace Config;

require 'config.php';

use PDO;
use PDOException;

final class Database
{

    private static ?Database $instance = null;
    private static PDO $conn;

    private string $db_host = DB_HOST;
    private string $db_name = DB_NAME;
    private string $db_user = DB_USER;
    private string $db_pass = DB_PASS;

    public static function getInstance(): Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {}

    private function __clone() {}

    private function __wakeup() {}

    /**
     * Database connection
     *
     * @return false|string|void
     */
    public static function connection()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

        try {
            self::$conn = new PDO($dsn, DB_USER, DB_PASS);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch (PDOException $e){
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }

    }

    public static function getConnection(): PDO
    {
        return self::$conn;
    }

}
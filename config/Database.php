<?php

namespace Config;

require 'config.php';

use PDO;
use PDOException;

class Database
{
    private string $db_host = DB_HOST;
    private string $db_name = DB_NAME;
    private string $db_user = DB_USER;
    private string $db_pass = DB_PASS;

    /**
     * Database connection
     *
     * @return false|PDO|string
     */
    public function getConnection()
    {

        $dsn = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name;

        try {
            $conn = new PDO($dsn, $this->db_user, $this->db_pass);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }

        return $conn;
    }

}
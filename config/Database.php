<?php

namespace Config;

use PDO;
use PDOException;

include 'config.php';

class Database
{
    protected $conn;

    /**
     * Database connection
     *
     * @return false|PDO|string
     */
    public function getConnection()
    {
        $this->conn = null;

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

        try {

            $this->conn = new PDO($dsn, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch (PDOException $e){

            return json_encode([
                'error' => $e->getMessage(),
            ]);

        }

        return $this->conn;
    }

}
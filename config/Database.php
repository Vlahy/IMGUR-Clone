<?php

namespace Config;

require 'config.php';

use PDO;
use PDOException;

class Database
{

    /**
     * Database connection parameters
     * Edit them in config.php file
     *
     * @var $conn
     * @var $db_host
     * @var $db_name
     * @var $db_user
     * @var $db_pass
     */
    protected $conn = null;
    protected string $db_host = DB_HOST;
    protected string $db_name = DB_NAME;
    protected string $db_user = DB_USER;
    protected string $db_pass = DB_PASS;

    /**
     * Database connection
     *
     * @return false|PDO|string
     */
    public function getConnection()
    {
        $this->conn = null;

        $dsn = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name;

        try {
            $this->conn = new PDO($dsn, $this->db_user, $this->db_pass);
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
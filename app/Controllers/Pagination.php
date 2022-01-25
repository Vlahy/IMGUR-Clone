<?php

namespace App\Controllers;

use Config\Database;

class Pagination
{

    private Database $conn;
    private string $table;
    private int $totalRecords;
    private int $limit = 10;

    public function __construct($table)
    {
        $this->table = $table;
        $this->conn = Database::getInstance();
        $this->setTotalRecords();
    }

    public function setTotalRecords()
    {
        $db = $this->conn->getConnection();
        $query = "SELECT COUNT(id) FROM $this->table";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $this->totalRecords = $stmt->rowCount();
    }

    public function getCurrentPage(): int
    {
        return isset($_GET['page']) ? (int)$_GET['page'] : 1;
    }

    public function offset(): int
    {
        $start = 0;
        if ($this->getCurrentPage() > 1) {
            return ($this->getCurrentPage() * $this->limit - $this->limit());
        } else {
            return $start;
        }
    }

    public function limit(): int
    {
        return $this->limit;
    }

}
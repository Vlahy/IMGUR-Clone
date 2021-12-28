<?php

namespace App\Models;

use Config\Database;
use PDO;

class ImageModel
{

    private Database $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getImage($id, $hide)
    {
        $db = $this->conn->getConnection();

        if ($hide == true){
            $query = "SELECT * FROM image WHERE id = :id AND nsfw = 0 and hidden = 0";
        }else{
            $query = "SELECT * FROM image WHERE id = :id";
        }

        $stmt = $db->prepare($query);

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            return null;
        }

    }

    public function deleteImage($id): bool
    {

        $db = $this->conn->getConnection();

        $stmt = $db->prepare("DELETE FROM image WHERE id = :id");

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;

    }

    public function setAsNsfw($id): bool
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("UPDATE image SET nsfw = 1 WHERE id = :id");

        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function setAsHidden($id): bool
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("UPDATE image SET hidden = 1 WHERE id = :id");

        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
<?php

namespace App\Models;

use Config\Database;
use PDO;

class CommentModel
{

    private Database $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function getGalleryComment($id)
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("SELECT c.comment, u.username FROM comment c JOIN user u ON u.id = c.user_id WHERE gallery_id = :id");

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function getImageComment($id)
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("SELECT c.comment, u.username FROM comment c JOIN user u on u.id = c.user_id WHERE image_id = :id");

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function storeGalleryComment($data): bool
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("INSERT INTO comment (user_id, gallery_id, comment) VALUES (:user_id, :gallery_id, :comment)");

        $stmt->bindValue(':user_id', $data['user_id']);
        $stmt->bindValue(':gallery_id', $data['gallery_id']);
        $stmt->bindValue(':comment', $data['comment']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function storeImageComment($data): bool
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("INSERT INTO comment (user_id, image_id, comment) VALUES (:user_id, :image_id, :comment)");

        $stmt->bindValue(':user_id', $data['user_id']);
        $stmt->bindValue(':image_id', $data['image_id']);
        $stmt->bindValue(':comment', $data['comment']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
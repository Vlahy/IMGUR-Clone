<?php

namespace App\Models;

use Config\Database;

class LoggerModel
{

    private Database $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function setGallery($userId, $galleryId, $comment): bool
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("INSERT INTO logger (user_id, gallery_id, comment, date) VALUES (:userId, :galleryId, :comment, NOW())");

        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':galleryId', $galleryId);
        $stmt->bindValue(':comment', $comment);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function setImage($userId, $imageId, $comment): bool
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("INSERT INTO logger (user_id, image_id, comment, date) VALUES (:userId, :imageId, :comment, NOW())");

        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':imageId', $imageId);
        $stmt->bindValue(':comment', $comment);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
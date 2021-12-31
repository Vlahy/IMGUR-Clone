<?php

namespace App\Models;

use Config\Database;
use PDO;

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

    public function listData($limit, $offset)
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("SELECT u.username, l.comment, g.name, i.id as image_id, g.id as gallery_id, l.date FROM logger l JOIN user u on l.user_id = u.id LEFT JOIN image i on l.image_id = i.id LEFT JOIN gallery g on l.gallery_id = g.id LIMIT :limit OFFSET :offset");

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }

    }

}
<?php

namespace App\Models;

use Config\Database;
use PDO;
use Predis\Client;
use App\Models\Enums\RedisConfig;

class CommentModel implements RedisConfig
{

    private Database $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    public function getGalleryComment($id)
    {
        $redis = new Client();
        $redis->connect(RedisConfig::REDIS_HOST,RedisConfig::REDIS_PORT);

        if (!$redis->get(RedisConfig::GALLERY_COMMENT . $id)) {
            $db = $this->conn->getConnection();

            $stmt = $db->prepare("SELECT c.comment, u.username FROM comment c JOIN user u ON u.id = c.user_id WHERE gallery_id = :id ORDER BY c.id DESC");

            $stmt->bindValue(':id', $id);

            if ($stmt->execute()) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $redis->set(RedisConfig::GALLERY_COMMENT . $id, serialize($data));
                $redis->expire(RedisConfig::GALLERY_COMMENT . $id, 600);
                return $data;
            } else {
                return false;
            }
        } else {
            return unserialize($redis->get(RedisConfig::GALLERY_COMMENT . $id));
        }
    }

    public function getImageComment($id)
    {
        $redis = new Client();
        $redis->connect(RedisConfig::REDIS_HOST,RedisConfig::REDIS_PORT);

        if (!$redis->get(RedisConfig::IMAGE_COMMENT . $id)) {

            $db = $this->conn->getConnection();

            $stmt = $db->prepare("SELECT c.comment, u.username FROM comment c JOIN user u on u.id = c.user_id WHERE image_id = :id ORDER BY c.id DESC");

            $stmt->bindValue(':id', $id);

            if ($stmt->execute()) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $redis->set(RedisConfig::IMAGE_COMMENT . $id, serialize($data));
                $redis->expire(RedisConfig::IMAGE_COMMENT . $id, 600);
                return $data;
            } else {
                return false;
            }
        } else {
            return unserialize($redis->get(RedisConfig::IMAGE_COMMENT . $id));
        }
    }

    public function storeGalleryComment($data): bool
    {
        $redis = new Client();
        $redis->connect(RedisConfig::REDIS_HOST,RedisConfig::REDIS_PORT);

        if ($redis->get(RedisConfig::GALLERY_COMMENT . $data['gallery_id'])) {
            $redis->del(RedisConfig::GALLERY_COMMENT . $data['gallery_id']);
        }

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
        $redis = new Client();
        $redis->connect(RedisConfig::REDIS_HOST,RedisConfig::REDIS_PORT);

        if ($redis->get(RedisConfig::IMAGE_COMMENT . $data['image_id'])) {
            $redis->del(RedisConfig::IMAGE_COMMENT . $data['image_id']);
        }

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
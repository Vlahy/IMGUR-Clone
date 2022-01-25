<?php

namespace App\Models;

use Config\Database;
use PDO;
use Predis\Client;
use App\Models\Enums\RedisConfig;

class LoggerModel implements RedisConfig
{

    private Database $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    public function setGallery($userId, $galleryId, $comment): bool
    {
        $redis = new Client();
        $redis->connect(RedisConfig::REDIS_HOST,RedisConfig::REDIS_PORT);

        if ($redis->get(RedisConfig::LOGGER)) {
            $redis->del(RedisConfig::LOGGER);
        }

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
        $redis = new Client();
        $redis->connect(RedisConfig::REDIS_HOST,RedisConfig::REDIS_PORT);

        if ($redis->get(RedisConfig::LOGGER)) {
            $redis->del(RedisConfig::LOGGER);
        }

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
        $redis = new Client();
        $redis->connect(RedisConfig::REDIS_HOST,RedisConfig::REDIS_PORT);

        if (!$redis->get(RedisConfig::LOGGER)) {

            $db = $this->conn->getConnection();

            $stmt = $db->prepare("SELECT u.username, l.comment, g.name, i.id as image_id, g.id as gallery_id, l.date FROM logger l JOIN user u on l.user_id = u.id LEFT JOIN image i on l.image_id = i.id LEFT JOIN gallery g on l.gallery_id = g.id LIMIT :limit OFFSET :offset");

            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $redis->set(RedisConfig::LOGGER, serialize($data));
                $redis->expire(RedisConfig::LOGGER, 600);
                return $data;
            } else {
                return false;
            }
        } else {
            return unserialize($redis->get(RedisConfig::LOGGER));
        }

    }

}
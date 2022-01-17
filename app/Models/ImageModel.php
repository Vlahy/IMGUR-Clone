<?php

namespace App\Models;

use Config\Database;
use PDO;
use Predis\Client;
use App\Models\Enums\RedisConfig;

class ImageModel implements RedisConfig
{

    private Database $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    public function getImage($id, $hide)
    {

        $redis = new Client();

        if (!$redis->get(RedisConfig::ONE_IMAGE . $id)) {

            $db = $this->conn->getConnection();

            if ($hide == true) {
                $query = "SELECT * FROM image WHERE id = :id AND nsfw = 0 and hidden = 0";
            } else {
                $query = "SELECT * FROM image WHERE id = :id";
            }

            $stmt = $db->prepare($query);

            $stmt->bindValue(':id', $id);

            if ($stmt->execute()) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $redis->set(RedisConfig::ONE_IMAGE . $id, serialize($data));
                $redis->expire(RedisConfig::ONE_IMAGE . $id, 600);
                return $data;
            } else {
                return null;
            }
        }else {
            return unserialize($redis->get(RedisConfig::ONE_IMAGE . $id));
        }
    }

    public function getAllImages(int $limit, int $offset)
    {

        $page = $_GET['page'] ?? 1;

        $redis = new Client();

        if (!$redis->get(RedisConfig::ALL_IMAGES . '_PAGE' . $page)) {

            $db = $this->conn->getConnection();

            $query = "SELECT * FROM image WHERE hidden = 0 and nsfw = 0 LIMIT :limit OFFSET :offset";

            $stmt = $db->prepare($query);

            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $redis->set(RedisConfig::ALL_IMAGES . '_PAGE' . $page, serialize($data));
                $redis->expire(RedisConfig::ALL_IMAGES . '_PAGE' . $page, 600);
                return $data;
            } else {
                return null;
            }
        } else {
            return unserialize($redis->get(RedisConfig::ALL_IMAGES . '_PAGE' . $page));
        }
    }

    public function storeImage(array $data): bool
    {
        $db = $this->conn->getConnection();

        $query = "INSERT INTO image (user_id, file_name, slug, nsfw, hidden) VALUES (:user_id, :file_name, :slug, :nsfw, :hidden)";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $data['user_id']);
        $stmt->bindValue(':file_name', $data['file_name']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':nsfw', 0);
        $stmt->bindValue(':hidden', 0);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteImage($id): bool
    {
        $redis = new Client();

        if ($redis->get(RedisConfig::ONE_IMAGE . $id)) {
            $redis->del(RedisConfig::ONE_IMAGE . $id);
        }

        $db = $this->conn->getConnection();

        $stmt = $db->prepare("DELETE FROM image WHERE id = :id");

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;

    }

    public function updateImage($data): bool
    {
        $redis = new Client();

        if ($redis->get(RedisConfig::ONE_IMAGE . $data['id'])) {
            $redis->del(RedisConfig::ONE_IMAGE . $data['id']);
        }

        $db = $this->conn->getConnection();

        $stmt = $db->prepare('UPDATE image SET slug = :slug WHERE id = :id');

        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':id', $data['id']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function setAsNsfw($id): bool
    {
        $redis = new Client();

        if ($redis->get(RedisConfig::ONE_IMAGE . $id)) {
            $redis->del(RedisConfig::ONE_IMAGE . $id);
        }

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
        $redis = new Client();

        if ($redis->get(RedisConfig::ONE_IMAGE . $id)) {
            $redis->del(RedisConfig::ONE_IMAGE . $id);
        }

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
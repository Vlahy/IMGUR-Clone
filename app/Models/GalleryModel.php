<?php

namespace App\Models;

use App\Models\Enums\RedisConfig;
use Config\Database;
use PDO;
use Predis\Client;

class GalleryModel implements RedisConfig
{


    private Database $conn;
    private Client $redis;

    public function __construct()
    {
        $this->conn = Database::getInstance();
        $this->redis = new Client();
    }

    public function listGalleries($id, $limit, $offset, $hide)
    {
        $page = $_GET['page'] ?? 1;


        if (!$this->redis->get(RedisConfig::ALL_GALLERIES . $id . 'PAGE' . $page)) {
            $db = $this->conn->getConnection();

            if ($hide === true) {
                $query = "select * from gallery where user_id = :user_id and nsfw = 0 and hidden = 0 limit :limit offset :offset";
            } else {
                $query = "select * from gallery where user_id = :user_id limit :limit offset :offset";
            }

            $stmt = $db->prepare($query);

            $stmt->bindValue(':user_id', $id);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $data = $stmt->fetchAll(PDO::FETCH_OBJ);
                $this->redis->set(RedisConfig::ALL_GALLERIES . $id . 'PAGE' . $page, serialize($data));
                $this->redis->expire(RedisConfig::ALL_GALLERIES . $id . 'PAGE' . $page, 600);
                return $data;
            } else {
                return false;
            }
        } else {
            return unserialize($this->redis->get(RedisConfig::ALL_GALLERIES . $id . 'PAGE' . $page));
        }
    }

    public function getOneGallery($galleryId, int $limit, int $offset)
    {

        $page = $_GET['page'] ?? 1;

        if (!$this->redis->get(RedisConfig::ONE_GALLERY . $galleryId . 'PAGE' . $page)) {
            $db = $this->conn->getConnection();

            $query = "select * from image where id in (select image_id from image_gallery where gallery_id = :galleryID) limit :limit offset :offset";

            $stmt = $db->prepare($query);

            $stmt->bindValue(':galleryID', $galleryId . 'PAGE' . $page);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $data = $stmt->fetchAll(PDO::FETCH_OBJ);
                $this->redis->set(RedisConfig::ONE_GALLERY . $galleryId . 'PAGE' . $page, serialize($data));
                $this->redis->expire(RedisConfig::ONE_GALLERY . $galleryId . 'PAGE' . $page, 600);
                return $data;
            } else {
                return false;
            }
        } else {
            return unserialize($this->redis->get(RedisConfig::ONE_GALLERY . $galleryId . 'PAGE' . $page));
        }
    }

    public function getGalleryInfo($galleryId)
    {

        $db = $this->conn->getConnection();

        $query = "select * from gallery where id = :galleryId";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':galleryId', $galleryId);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function storeGallery(array $data): bool
    {
        $this->redis->flushall();
        $db = $this->conn->getConnection();

        $query = "INSERT INTO gallery (user_id, name, nsfw, hidden, description, slug) VALUES (:user_id, :name, :nsfw, :hidden, :description, :slug)";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $data['user_id']);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':nsfw', 0);
        $stmt->bindValue(':hidden', 0);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':slug', $data['slug']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteGallery($id): bool
    {

        if ($this->redis->get(RedisConfig::ONE_GALLERY . $id)) {
            $this->redis->del(RedisConfig::ONE_GALLERY . $id);
        }

        $db = $this->conn->getConnection();

        $query = "DELETE FROM gallery WHERE id = :id";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function updateGalleryInfo($data): bool
    {

        if ($this->redis->get(RedisConfig::ONE_GALLERY . $data['id'])) {
            $this->redis->del(RedisConfig::ONE_GALLERY . $data['id']);
        }

        $db = $this->conn->getConnection();

        $stmt = $db->prepare("UPDATE gallery SET name = :name, description = :description WHERE id = :id");

        $stmt->bindValue(':id', $data['id']);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':description', $data['description']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function setAsNsfw($id): bool
    {

        if ($this->redis->get(RedisConfig::ONE_GALLERY . $id)) {
            $this->redis->del(RedisConfig::ONE_GALLERY . $id);
        }

        $db = $this->conn->getConnection();

        $stmt = $db->prepare("UPDATE gallery SET nsfw = 1 WHERE id = :id");

        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function setAsHidden($id): bool
    {

        if ($this->redis->get(RedisConfig::ONE_GALLERY . $id)) {
            $this->redis->del(RedisConfig::ONE_GALLERY . $id);
        }

        $db = $this->conn->getConnection();

        $stmt = $db->prepare("UPDATE gallery SET hidden = 1 WHERE id = :id");

        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


}
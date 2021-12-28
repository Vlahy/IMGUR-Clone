<?php

namespace App\Models;

use Config\Database;
use PDO;

class GalleryModel
{

    private Database $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function listGalleries($id, $limit, $offset, $hide)
    {
        $db = $this->conn->getConnection();

        if ($hide === true){
            $query = "select * from gallery where user_id = :user_id and nsfw = 0 and hidden = 0 limit :limit offset :offset";
        }else {
            $query = "select * from gallery where user_id = :user_id limit :limit offset :offset";
        }

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $id);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    public function getOneGallery($galleryID, $limit, $offset)
    {
        $db = $this->conn->getConnection();

        $query = "select * from image where id in (select image_id from image_gallery where gallery_id = :galleryID) limit :limit offset :offset";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':galleryID', $galleryID);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    public function deleteGallery($id): bool
    {
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

    public function setAsNsfw($id): bool
    {
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
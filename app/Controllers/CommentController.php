<?php

namespace App\Controllers;

use App\Models\CommentModel;
use Exception;

class CommentController extends BaseController
{

    private CommentModel $comment;

    public function __construct()
    {
        $this->comment = new CommentModel();
    }

    public function getGalleryComment($id)
    {
        return $this->comment->getGalleryComment($id) ?? null;
    }

    public function getImageComment($id)
    {
        return $this->comment->getImageComment($id) ?? null;
    }

    public function storeGalleryComment()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => trim($_POST['user_id']),
                'gallery_id' => trim($_POST['gallery_id']),
                'comment' => trim($_POST['comment']),
            ];

            try {
                $this->comment->storeGalleryComment($data);
                header('Location: /users/gallery/' . $data['gallery_id']);
            } catch (Exception $e) {
                return json_encode([
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    public function storeImageComment()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => trim($_POST['user_id']),
                'image_id' => trim($_POST['image_id']),
                'comment' => trim($_POST['comment']),
            ];

            try {
                $this->comment->storeImageComment($data);
                header('Location: /users/image/' . $data['image_id']);
            } catch (Exception $e) {
                return json_encode([
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

}
<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use App\Models\UserModel;
use App\Helpers\Slugify;

class GalleryController extends BaseController
{

    private GalleryModel $galleryModel;
    private Pagination $pagination;
    private string $table = 'gallery';
    private LoggerController $logger;
    private UserModel $userModel;
    private CommentController $comment;

    public function __construct(GalleryModel $galleryModel, LoggerController $loggerController, UserModel $userModel, CommentController $commentController)
    {
        $this->galleryModel = $galleryModel;
        $this->pagination = new Pagination($this->table);
        $this->logger = $loggerController;
        $this->userModel = $userModel;
        $this->comment = $commentController;
    }

    /**
     * Method for listing all galleries (with pagination)
     *
     * @param $id
     * @return void
     */
    public function index($id)
    {
        if ($this->userModel->isAuthor($id) == false) {
            $hide = true;
        } else {
            $hide = false;
        }

        $offset = $this->pagination->offset();
        $limit = $this->pagination->limit();

        $data = $this->galleryModel->listGalleries($id, $limit, $offset, $hide);

        $this->view('UserListGalleryView', $data);
    }

    /**
     * Method for showing one gallery
     *
     * @param $slug
     * @return void
     */
    public function show($id)
    {

        $offset = $this->pagination->offset();
        $limit = $this->pagination->limit();

        $data['gallery'] = $this->galleryModel->getOneGallery($id, $limit, $offset);
        $data['info'] = $this->galleryModel->getGalleryInfo($id);
        $data['comment'] = $this->comment->getGalleryComment($id);

        if (empty($data['info'])) {
            header('Location: /404');
        }

        if ($this->userModel->isAuthor($data['info'][0]['user_id']) === false && !$this->userModel->isAdmin()) {
            if ($data['info'][0]['hidden'] == 1 || $data['info'][0]['nsfw'] == 1) {
                header('Location: /404');
            }
        }

        $this->view('GalleryView', $data);

    }

    /**
     * Method for creating gallery
     *
     * @return false|string|void
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => trim($_POST['user_id']),
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'slug' => Slugify::slugify($_POST['name']),
            ];

            try {
                $this->galleryModel->storeGallery($data);
                header('Location: /users/profile/' . $_SESSION['user_id']);

            } catch (\Exception $e) {
                return json_encode([
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]);
            }
        }
    }

    /**
     * Method for updating gallery info
     *
     * @return false|string|void
     */
    public function update()
    {
        $data = [
            'id' => '',
            'name' => '',
            'description' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
            ];

            try {

                $this->galleryModel->updateGalleryInfo($data);
                header('Location: /users/gallery/' . $_POST['id']);

            } catch (\Exception $e) {
                return json_encode([
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Method for deleting gallery
     *
     * @param $id
     * @return false|string|void
     */
    public function delete($id)
    {
        try {
            $this->galleryModel->deleteGallery($id);
            header('Location: /users/profile/' . $_SESSION['user_id']);
        } catch (\Exception $e) {
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Method for setting gallery as NSFW
     *
     * @param $id
     * @return false|string|void
     */
    public function setGalleryAsNsfw($id)
    {
        try {
            if ($this->galleryModel->setAsNsfw($id)) {

                $this->logger->setGalleryAsNsfw($_SESSION['user_id'], $id);
                header('Location: /users/profile/' . $_SESSION['user_id']);

            }
        } catch (\Exception $e) {

            return json_encode([
                'error' => $e->getMessage(),
            ]);

        }
    }

    /**
     * Method for setting gallery as hidden
     *
     * @param $id
     * @return false|string|void
     */
    public function setGalleryAsHidden($id)
    {
        try {
            if ($this->galleryModel->setAsHidden($id)) {
                $this->logger->setGalleryAsHidden($_SESSION['user_id'], $id);
                header('Location: /users/profile/' . $_SESSION['user_id']);
            }

        } catch (\Exception $e) {
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
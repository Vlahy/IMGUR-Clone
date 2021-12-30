<?php

namespace App\Controllers;

use App\Models\ImageModel;
use App\Models\UserModel;

class ImageController extends BaseController
{

    private ImageModel $imageModel;
    private LoggerController $logger;
    private UserModel $userModel;
    private CommentController $comment;

    public function __construct()
    {
        $this->imageModel = new ImageModel();
        $this->logger = new LoggerController();
        $this->userModel = new UserModel();
        $this->comment = new CommentController();
    }

    /**
     * Method for showing one image
     *
     * @param $id
     * @return void
     */
    public function show($id)
    {

        $data = [];

        $user = $_SESSION['user_id'] ?? null;
        if ($this->userModel->isAuthor($user)){
            $hide = false;
        }else{
            $hide = true;
        }

        $data['image'] = $this->imageModel->getImage($id, $hide);
        $data['comment'] = $this->comment->getImageComment($id);

        $this->view('ImageView', $data);

    }

    public function store()
    {
        // TODO: Implement store() method.
    }

    /**
     * Method for updating image info
     *
     * @return false|string|void
     */
    public function update()
    {
        $data = [
            'id' => '',
            'slug' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_POST['id']),
                'slug' => trim($_POST['slug']),
            ];

            try {
                $this->imageModel->updateImage($data);
                header('Location: /users/image/' . $data['id']);
            }catch (\Exception $e) {
                return json_encode([
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Method for deleting image
     *
     * @param $id
     * @return false|string|void
     */
    public function delete($id)
    {
        try {

            $this->imageModel->deleteImage($id);
            header('Location: /users/profile/' . $_SESSION['user_id']);

        } catch (\Exception $e) {
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Method for setting image as NSFW
     *
     * @param $id
     * @return false|string|void
     */
    public function setImageAsNsfw($id)
    {
        try {
            if ($this->imageModel->setAsNsfw($id)) {

                $this->logger->setImageAsNsfw($_SESSION['user_id'], $id);
                header('Location: /users/image/' . $id);

            }
        } catch (\Exception $e) {

            return json_encode([
                'error' => $e->getMessage(),
            ]);

        }
    }

    /**
     * Method for setting image as hidden
     *
     * @param $id
     * @return false|string|void
     */
    public function setImageAsHidden($id)
    {
        try {
            if ($this->imageModel->setAsHidden($id)) {
                $this->logger->setImageAsHidden($_SESSION['user_id'], $id);
                header('Location: /users/image/' . $id);
            }
        } catch (\Exception $e) {
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }
    }

}
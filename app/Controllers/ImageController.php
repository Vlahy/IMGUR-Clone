<?php

namespace App\Controllers;

use App\Models\ImageModel;
use App\Models\UserModel;

class ImageController extends BaseController
{

    private ImageModel $imageModel;
    private LoggerController $logger;
    private UserModel $userModel;

    public function __construct()
    {
        $this->imageModel = new ImageModel();
        $this->logger = new LoggerController();
        $this->userModel = new UserModel();
    }

    /**
     * Method for showing one image
     *
     * @param $id
     * @return void
     */
    public function show($id)
    {
        $user = $_SESSION['user_id'] ?? null;
        if ($this->userModel->isAuthor($user)){
            $hide = false;
        }else{
            $hide = true;
        }

        $image = $this->imageModel->getImage($id, $hide) ?? null;

        $data = [
          'id' => $image->id,
          'user_id' => $image->user_id,
          'file_name' => $image->file_name,
          'slug' => $image->slug,
          'nsfw' => $image->nsfw,
          'hidden' => $image->hidden,
        ];

        $this->view('ImageView', $data);

    }

    public function store()
    {
        // TODO: Implement store() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
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
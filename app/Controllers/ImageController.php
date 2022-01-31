<?php

namespace App\Controllers;

use App\Helpers\Slugify;
use App\Models\CommentModel;
use App\Models\ImageModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

class ImageController extends BaseController
{

    private LoggerController $logger;
    private UserModel $userModel;
    private string $table = 'image';
    private Pagination $pagination;
    private CommentController $commentController;
    private ImageModel $imageModel;
    private SubscriptionModel $subscriptionModel;

    public function __construct(ImageModel $imageModel,
                                CommentController $commentController,
                                LoggerController $loggerController,
                                UserModel $userModel,
                                SubscriptionModel $subscriptionModel)
    {
        $this->imageModel = $imageModel;
        $this->commentController = $commentController;
        $this->logger = $loggerController;
        $this->userModel = $userModel;
        $this->pagination = new Pagination($this->table);
        $this->subscriptionModel = $subscriptionModel;
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
        if ($this->userModel->isAuthor($user)) {
            $hide = false;
        } else {
            $hide = true;
        }

        $data['image'] = $this->imageModel->getImage($id, $hide);
        $data['comment'] = $this->commentController->getImageComment($id);

        if (empty($data['image'])){
            header('Location: /404');
        }

        $this->view('ImageView', $data);

    }

    /**
     * Method for listing all images to not logged user
     *
     * @return void
     */
    public function listAllImages()
    {
        $limit = $this->pagination->limit();
        $offset = $this->pagination->offset();

        $data = $this->imageModel->getAllImages($limit, $offset);

        if (empty($data)){
            header('Location: /404');
        }

        $this->view('IndexView', $data);
    }

    /**
     * Method for storing images
     *
     * @return bool
     */
    public function store(): bool
    {

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $maxUploads = $this->subscriptionModel->getMonthlyLimit($_POST['user_id']);
            $uploaded = $this->subscriptionModel->checkCurrentUploadLimit($_POST['user_id']);
            if ((int)$maxUploads['monthly_limit'] <= (int)$uploaded['uploaded_images']){
                die(json_encode(array('error' => 'You have reached monthly limit for image uploads!')));
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK){

                $info = getimagesize($_FILES['image']['tmp_name']);
                $allowedTypes = [
                    IMAGETYPE_JPEG => 'image/jpeg',
                    IMAGETYPE_PNG => 'image/png',
                    IMAGETYPE_GIF => 'image/gif',
                ];

                if ($info === false) {
                    die();
                }else if (!array_key_exists($info[2], $allowedTypes)) {
                    die();
                }else {
                    $path = $_SERVER['DOCUMENT_ROOT'] . '/images/';
                    $fileName = date('Y-m-d H:i:s') . $_FILES['image']['name'];
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $path . $fileName)) {

                        $data = [
                            'user_id' => trim($_POST['user_id']),
                            'gallery_id' => trim($_POST['gallery_id']),
                            'file_name' => $fileName,
                            'slug' => Slugify::slugify(pathinfo($fileName, PATHINFO_FILENAME)),
                        ];

                        try {
                            $this->imageModel->storeImage($data);

                            $this->imageModel->storeImageInGallery($data);

                            $this->subscriptionModel->incrementImageLimit($_POST['user_id']);

                            header('Location: /users/gallery/' . $data['gallery_id']);
                        } catch (\Exception $e) {
                            return json_encode([
                                'error' => $e->getMessage(),
                                'code' => $e->getCode(),
                            ]);
                        }
                    } else {
                        die();
                    }
                }
            }
        }
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_POST['id']),
                'slug' => trim($_POST['slug']),
            ];

            try {
                $this->imageModel->updateImage($data);
                header('Location: /users/image/' . $data['id']);
            } catch (\Exception $e) {
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
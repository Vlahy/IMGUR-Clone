<?php

namespace App\Controllers;

use App\Models\LoggerModel;

class LoggerController extends BaseController
{

    private LoggerModel $loggerModel;

    public function __construct()
    {
        $this->loggerModel = new LoggerModel();
    }

    public function setImageAsHidden($userId, $imageId)
    {
        $comment = "Set image as hidden!";

        try {
            $this->loggerModel->setImage($userId, $imageId, $comment);
            return true;
        }catch (\Exception $e){
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }

    }

    public function setImageAsNsfw($userId, $imageId)
    {
        $comment = "Set image as nsfw!";

        try {
            $this->loggerModel->setImage($userId, $imageId, $comment);
            return true;
        }catch (\Exception $e){
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }

    }

    public function setGalleryAsHidden($userId, $galleryId)
    {
        $comment = "Set gallery as hidden!";

        try {
            $this->loggerModel->setGallery($userId, $galleryId, $comment);
            return true;
        }catch (\Exception $e){
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }

    }

    public function setGalleryAsNsfw($userId, $galleryId)
    {
        $comment = "Set gallery as nsfw!";

        try {
            $this->loggerModel->setGallery($userId, $galleryId, $comment);
            return true;
        }catch (\Exception $e){
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }

    }

}
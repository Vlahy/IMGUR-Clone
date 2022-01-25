<?php

namespace App\Controllers;

use App\Models\LoggerModel;

class LoggerController extends BaseController
{

    private LoggerModel $loggerModel;
    private Pagination $pagination;
    private string $table = 'logger';

    public function __construct()
    {
        $this->loggerModel = new LoggerModel();
        $this->pagination = new Pagination($this->table);
    }

    public function setImageAsHidden($userId, $imageId)
    {
        $comment = "set image as hidden!";

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
        $comment = "set image as nsfw!";

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
        $comment = "set gallery as hidden!";

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
        $comment = "set gallery as nsfw!";

        try {
            $this->loggerModel->setGallery($userId, $galleryId, $comment);
            return true;
        }catch (\Exception $e){
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }

    }

    public function getData()
    {

        $limit = $this->pagination->limit();
        $offset = $this->pagination->offset();

        try {
            return $this->loggerModel->listData($limit, $offset);
        } catch (\Exception $e) {
            return json_encode([
                'error' => $e->getMessage(),
            ]);
        }
    }

}
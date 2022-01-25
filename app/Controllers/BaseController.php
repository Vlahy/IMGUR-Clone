<?php

namespace App\Controllers;

class BaseController
{

    public function view($view, $data = [])
    {
        if (file_exists(dirname(__DIR__, 1) . '/Views/' . $view . '.php')) {
            require_once dirname(__DIR__, 1) . '/Views/' . $view . '.php';
        }else{
            die('View does not exists');
        }
    }

}
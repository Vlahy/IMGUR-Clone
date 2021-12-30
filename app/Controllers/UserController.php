<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController implements Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function show()
    {
        $data = [];


        $this->view('UserProfileView', $data);
    }

    public function store()
    {
        // TODO: Implement store() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}
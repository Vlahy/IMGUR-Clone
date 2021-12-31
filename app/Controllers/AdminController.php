<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\Enums\UserRoleData as Role;

class AdminController extends BaseController
{

    private LoggerController $logger;
    private UserModel $userModel;

    public function __construct()
    {
        $this->logger = new LoggerController();
        $this->userModel = new UserModel();
    }

    public function listLoggerData()
    {
        $data = $this->logger->getData() ?? null;

        $this->view('AdminPanelView', $data);
    }

    public function changeRole()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $role = in_array($_POST['role'], Role::ROLES);

            if ($role) {
                $data = [
                    'user_id' => trim($_POST['user_id']),
                    'role' => trim($_POST['role']),
                ];

                try {
                    $this->userModel->changeRole($data);
                    header('Location: /admin/panel');
                }catch (\Exception $e) {
                    return json_encode([
                        'error' => $e->getMessage(),
                    ]);
                }
            }else {
                header('Location: /');

            }

        }
    }

}
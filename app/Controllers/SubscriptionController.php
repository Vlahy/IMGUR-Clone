<?php

namespace App\Controllers;

use App\Adapters\PaymentAdapter;
use App\Models\SubscriptionModel;
use App\Models\UserModel;
use DateTime;

class SubscriptionController extends BaseController
{

    private SubscriptionModel $subscriptionModel;
    private UserModel $userModel;

    public function __construct(SubscriptionModel $subscriptionModel, UserModel $userModel)
    {
        $this->subscriptionModel = $subscriptionModel;
        $this->userModel = $userModel;
    }

    public function getCurrentSubscription($id)
    {
        try {

            return $this->subscriptionModel->getCurrentSubscription($id);

        } catch (\Exception $e) {
            return json_encode([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
        }
    }

    public function getSubscriptionHistory(int $id)
    {
        try {

            return $this->subscriptionModel->getSubscriptionHistory($id);

        } catch (\Exception $e) {
            return json_encode([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
        }
    }

    public function create()
    {
        $data = [];

        $this->view('SubscriptionFormView', $data);
    }

    public function store()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $dateAndLimit = $this->subscriptionModel->setSubscriptionDateAndMonthlyLimit($_POST['subscription_type']);

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id'                => trim($_POST['user_id']),
                'subscription_type'      => trim($_POST['subscription_type']),
                'start_date'             => $dateAndLimit['date']['start_date'],
                'end_date'               => $dateAndLimit['date']['end_date'],
                'is_active'              => true,
                'monthly_limit'          => $dateAndLimit['monthlyLimit'],
                'uploaded_images'        => 0,
            ];

            try {

                $this->subscriptionModel->toggleFreeSubscription($_SESSION['user_id'], false);

                $this->subscriptionModel->subscribeUser($data);
                header('Location: /users/profile/' . $_POST['user_id']);
            } catch (\Exception $e) {
                return json_encode([
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]);
            }

        }

    }

    public function storeOnRegister(string $email)
    {
        $user_id = $this->userModel->getUserIdByEmail($email);

        $dateAndLimit = $this->subscriptionModel->setSubscriptionDateAndMonthlyLimit('free', 'now');

        $data = [
            'user_id' => $user_id[0]['id'],
            'subscription_type' => 'free',
            'start_date' => $dateAndLimit['date']['start_date'],
            'end_date' => $dateAndLimit['date']['end_date'],
            'is_active' => true,
            'monthly_limit' => $dateAndLimit['monthlyLimit'],
            'uploaded_images' => 0,
        ];

        $this->subscriptionModel->subscribeUser($data);

    }

    public function cancelSubscription()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => trim($_POST['user_id']),
                'subscription_id' => trim($_POST['subscription_id'])
            ];

            try {
                $this->subscriptionModel->cancelSubscription($data);
                $this->subscriptionModel->toggleFreeSubscription($_SESSION['user_id'], true);
                header('Location: /users/profile/' . $_SESSION['user_id']);
            } catch (\Exception $e) {
                return json_encode([
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]);
            }
        }

    }

    public function changeSubscriptionType()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => trim($_POST['user_id']),
                'desired_subscription_type' => trim($_POST['change_subscription_type']),
            ];

            try {

                $this->subscriptionModel->changeSubscription($data);

                header('Location: /users/profile/' . trim($_POST['user_id']));

            } catch (\Exception $e) {
                return json_encode([
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]);
            }

        }

    }

}


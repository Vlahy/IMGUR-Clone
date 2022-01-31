<?php

namespace App\Models;

use App\Interfaces\SubscriptionInterface;
use App\Models\Enums\SubscriptionTypes;
use Config\Database;
use DateTime;
use Exception;
use PDO;

class SubscriptionModel implements SubscriptionInterface, SubscriptionTypes
{

    private Database $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Method for getting current subscription
     *
     * @param int $id
     *
     * @return array|false
     */
    public function getCurrentSubscription(int $id)
    {
        if (!isset($id)){
            return false;
        }

        $db = $this->database->getConnection();

        $query = "SELECT id, subscription_type, end_date, is_active FROM user_subscriptions where user_id = :user_id and is_active = true";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $id);

        if ($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    /**
     * Method for getting all subscriptions of one user
     *
     * @param int $id
     *
     * @return array|false
     */
    public function getSubscriptionHistory(int $id)
    {
        if (!isset($id)){
            return false;
        }

        $db = $this->database->getConnection();

        $query = "SELECT subscription_type, start_date, end_date, is_active FROM user_subscriptions where user_id = :user_id";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $id);

        if ($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    /**
     * Method for getting and returning subscription type
     *
     * @param int $id
     *
     * @return array|false
     */
    public function getSubscriptionType(int $id)
    {
        if (!isset($id)) {
            return false;
        }

        $db = $this->database->getConnection();

        $query = "SELECT subscription_type FROM user_subscriptions WHERE user_id = :user_id";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $id);

        if ($stmt->execute()) {

            $subscriptionType = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($subscriptionType)) {
                return false;
            }

            if (!array_key_exists($subscriptionType['subscription_type'], self::SUBSCRIPTION_TYPES)) {
                return false;
            }

            return $subscriptionType;

        } else {
            return false;
        }

    }

    /**
     * Method for getting monthly limit for image upload
     *
     * @param int $id
     *
     * @return false|mixed
     */
    public function getMonthlyLimit(int $id)
    {
        if (!isset($id)){
            return false;
        }

        $db = $this->database->getConnection();

        $query = "SELECT monthly_limit FROM user_subscriptions WHERE user_id = :user_id and is_active = true";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }

    }

    /**
     * Method for getting current number of images uploaded.
     *
     * @param int $id
     *
     * @return false|mixed
     */
    public function checkCurrentUploadLimit(int $id)
    {
        if (!isset($id)) {
            return false;
        }

        $db = $this->database->getConnection();

        $query = "SELECT uploaded_images FROM user_subscriptions WHERE user_id = :user_id and is_active = true";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }

    }

    /**
     * Method for creating subscription for user
     *
     * @param array $data
     *
     * @return bool
     */
    public function subscribeUser(array $data): bool
    {
        if (!isset($data)) {
            return false;
        }

        $db = $this->database->getConnection();

        $query = "INSERT INTO user_subscriptions (user_id, subscription_type, start_date, end_date, is_active, monthly_limit, uploaded_images) 
                                          VALUES (:user_id, :subscription_type, :start_date, :end_date, :is_active, :monthly_limit, :uploaded_images)";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id',           $data['user_id']);
        $stmt->bindValue(':subscription_type', $data['subscription_type']);
        $stmt->bindValue(':start_date',        $data['start_date']);
        $stmt->bindValue(':end_date',          $data['end_date']);
        $stmt->bindValue(':is_active',         $data['is_active']);
        $stmt->bindValue(':monthly_limit',         $data['monthly_limit']);
        $stmt->bindValue(':uploaded_images',         $data['uploaded_images']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Method for canceling user subscription
     *
     * @param array $data
     *
     * @return bool
     */
    public function cancelSubscription(array $data): bool
    {
        if (!isset($data)) {
            return false;
        }

        $db = $this->database->getConnection();

        $query = "UPDATE user_subscriptions SET is_active = false WHERE id = :id and user_id = :user_id";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':id', $data['subscription_id']);
        $stmt->bindValue(':user_id', $data['user_id']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * Method for updating user subscription
     *
     * @param array $data Array containing the necessary parameters
     *              $data = [
     *                    'user_id',
     *                    'subscription_type',
     *                    'start_date',
     *                    'end_date',
     *                    'is_active',
     *              ]
     *
     * @return bool
     */
    public function updateSubscription(array $data): bool
    {
        if (!isset($data)){
            return false;
        }

        $db = $this->database->getConnection();

        $query = "UPDATE user_subscriptions SET   subscription_type = :subscription_type,
                                                  start_date =        :start_date,
                                                  end_date =          :end_date,
                                                  is_active =         :is_active
                                            WHERE user_id =           :user_id";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':subscription_type',  $data['subscription_type']);
        $stmt->bindValue(':start_date',         $data['start_date']);
        $stmt->bindValue(':end_date',           $data['end_date']);
        $stmt->bindValue(':is_active',          $data['is_active']);
        $stmt->bindValue(':user_id',            $data['user_id']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Method for setting start and end dates for subscription
     * depending on type, also monthly limit depending on type.
     *
     * @param string $subscriptionType
     *
     * @return array|false
     */
    public function setSubscriptionDateAndMonthlyLimit(string $subscriptionType, string $start = 'now')
    {
        if (!isset($subscriptionType)){
            return false;
        }

        $date = new DateTime($start);

        $start_date = $date->format('Y-m-d H:m:s');

        switch ($subscriptionType){
            case 'one_month':
                $end_date = $date->modify('+30 day');
                $monthlyLimit = 20;
                break;

            case 'six_months':
                $end_date = $date->modify('+180 day');
                $monthlyLimit = 30;
                break;

            case 'twelve_months':
                $end_date = $date->modify('+365 day');
                $monthlyLimit = 50;
                break;

            default:
                $end_date = $date->modify('+30 day');
                $monthlyLimit = 5;
        }


        return [
            'date' => [
                'start_date' => $start_date,
                'end_date' => $end_date->format('Y-m-d H:m:s'),
                ],
            'monthlyLimit' => $monthlyLimit,
        ];

    }

    /**
     * Method for setting subscription to free
     *
     * @param int $id
     *
     * @return bool
     */
    public function toggleFreeSubscription(int $id, bool $isActive): bool
    {
        if (!isset($id)) {
            return false;
        }

        $db = $this->database->getConnection();

        if ($isActive == true){
            $query = "UPDATE user_subscriptions SET is_active = true WHERE user_id = :user_id and subscription_type = 'free'";
        } else {
            $query = "UPDATE user_subscriptions SET is_active = false WHERE user_id = :user_id and subscription_type = 'free'";
        }

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method for changing users subscription.
     *
     * @param array $data
     *
     * @return false|void
     */
    public function changeSubscription(array $data)
    {

        if (!isset($data)){
            return false;
        }

        $db = $this->database->getConnection();

        $currentSubscription = $this->getCurrentSubscription($data['user_id']);

        $currentSubscriptionType = array_search($currentSubscription[0]['subscription_type'], SubscriptionTypes::SUBSCRIPTION_PRIORITIES);

        $desiredSubscriptionType = array_search($data['desired_subscription_type'], SubscriptionTypes::SUBSCRIPTION_PRIORITIES);


        if ($currentSubscriptionType < $desiredSubscriptionType){

            $dateAndLimit = $this->setSubscriptionDateAndMonthlyLimit($data['desired_subscription_type'], 'now');

            $updateQuery = "UPDATE user_subscriptions SET is_active = false WHERE user_id = :user_id and id = :id";

            $update = $db->prepare($updateQuery);

            $update->bindValue(':user_id', $data['user_id']);
            $update->bindValue(':id', $currentSubscription[0]['id']);

            $update->execute();

            $insert = $db->prepare("INSERT INTO user_subscriptions (user_id, subscription_type, start_date, end_date, is_active, monthly_limit, uploaded_images)
                                                VALUES (:user_id, 'twelve_months', :start_date, :end_date, true, :monthly_limit, :uploaded_images)");

            $insert->bindValue(':user_id', $data['user_id']);
            $insert->bindValue(':start_date', $dateAndLimit['date']['start_date']);
            $insert->bindValue(':end_date', $dateAndLimit['date']['end_date']);
            $insert->bindValue(':monthly_limit', $dateAndLimit['monthlyLimit']);
            $insert->bindValue(':uploaded_images', 0, PDO::PARAM_INT);

            $insert->execute();

        }

        if ($currentSubscriptionType >= $desiredSubscriptionType) {

            $dateAndLimit = $this->setSubscriptionDateAndMonthlyLimit($data['desired_subscription_type'], $currentSubscription[0]['end_date']);

            $insertQuery = "INSERT INTO user_subscriptions (user_id, subscription_type, start_date, end_date, is_active, monthly_limit, uploaded_images)
                                                VALUES (:user_id, :subscription_type, :start_date, :end_date, false, :monthly_limit, :uploaded_images)";

            $insert = $db->prepare($insertQuery);

            $insert->bindValue(':user_id', $data['user_id']);
            $insert->bindValue(':subscription_type', $data['desired_subscription_type']);
            $insert->bindValue(':start_date', $dateAndLimit['date']['start_date']);
            $insert->bindValue(':end_date', $dateAndLimit['date']['end_date']);
            $insert->bindValue(':monthly_limit', $dateAndLimit['monthlyLimit']);
            $insert->bindValue(':uploaded_images', 0, PDO::PARAM_INT);


            $insert->execute();
        }

    }

    public function incrementImageLimit(int $id): bool
    {

        $currentLimit = $this->checkCurrentUploadLimit($id);

        $limit = (int)$currentLimit['uploaded_images'] + 1;

        $db = $this->database->getConnection();

        $query = "UPDATE user_subscriptions SET uploaded_images = :limit WHERE user_id = :user_id and is_active = true";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $id);
        $stmt->bindValue(':limit',  $limit, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

}

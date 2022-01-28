<?php
require __DIR__ . '/../vendor/autoload.php';

use Config\Database;

class PopulateTableSubscriptionScript
{

    private Database $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    public function getUsersCount(): array
    {
        $db = $this->conn->getConnection();

        $query = "SELECT id FROM user";

        $stmt = $db->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertSubscriptions()
    {

        $date = new DateTime('now');

        $start_date = $date->format('Y-m-d H:m:s');

        $end_date = $date->modify('+30 day')->format('Y-m-d H:m:s');

        $numOfUsers = $this->getUsersCount();

        $db = $this->conn->getConnection();

        $query = "INSERT INTO user_subscriptions (user_id, subscription_type, start_date, end_date, is_active, monthly_limit, uploaded_images)
                                          VALUES (:user_id, :subscription_type, :start_date, :end_date, :is_active, :monthly_limit, :uploaded_images)";

        foreach ($numOfUsers as $userId) {
            $stmt = $db->prepare($query);
            $stmt->bindValue(':user_id',                    $userId['id']);
            $stmt->bindValue(':subscription_type',    'free');
            $stmt->bindValue(':start_date',                 $start_date);
            $stmt->bindValue(':end_date',                   $end_date);
            $stmt->bindValue(':is_active',            true);
            $stmt->bindValue(':monthly_limit',        5);
            $stmt->bindValue(':uploaded_images',      0);
            $stmt->execute();
        }

    }

}

Database::connection();

$num = new PopulateTableSubscriptionScript();

$num->insertSubscriptions();

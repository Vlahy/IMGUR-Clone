<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Adapters\PaymentAdapter;
use App\Interfaces\PaymentInterface;
use App\PaymentClasses\VisaCreditCard;
use Config\Database;


Database::connection();

function currentDate()
{
    $date = new DateTime('now');

    return $date->format('Y-m-d H:m:s');
}

function getAllUsers()
{
    $instance = Database::getInstance();

    $db = $instance->getConnection();

    $query = "SELECT id, email FROM user";
//    $query = "SELECT user_id FROM user_subscriptions WHERE start_date = :date OR end_date < :date AND is_active = true AND subscription_type != 'free'";


    $stmt = $db->prepare($query);

    $stmt->bindValue(':date', currentDate());

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function paySubscription(PaymentInterface $payment)
{
    $getUsers = getAllUsers();

    foreach ($getUsers as $user){

        echo '----------------'.PHP_EOL;
        echo 'User id: ' . $user['user_id']. PHP_EOL;

        $payment->doPayment(true);

    }
}

$creditCardAdapter = new PaymentAdapter(new VisaCreditCard());

paySubscription($creditCardAdapter);
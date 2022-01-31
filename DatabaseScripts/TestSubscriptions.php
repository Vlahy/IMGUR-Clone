<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Adapters\PaymentAdapter;
use App\Interfaces\PaymentInterface;
use App\PaymentClasses\VisaCreditCard;
use Config\Database;


Database::connection();

function currentDate()
{
    $date = new DateTime();

    return $date->format('Y-m-d H:m:s');
}

function getAllUsers()
{
    $instance = Database::getInstance();

    $db = $instance->getConnection();

    // Uncomment this line if You want to test payment for all users and comment out next query
    $query = "SELECT id AS user_id FROM user";

    // Uncomment this line if You want to test payment for users that have expired subscriptions and comment out previous query
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


        $payment->doPayment($user['user_id']);


    }
}

$creditCardAdapter = new PaymentAdapter(new VisaCreditCard());

paySubscription($creditCardAdapter);
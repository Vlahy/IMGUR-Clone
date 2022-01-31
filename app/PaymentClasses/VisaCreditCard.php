<?php

namespace App\PaymentClasses;

use App\Interfaces\CreditCardInterface;
use Config\Database;
use PDO;

class VisaCreditCard implements CreditCardInterface
{

    private Database $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    /**
     * Method for checking if credit card is valid
     *
     * @param int $id
     * @return bool
     */
    public function validateCard(int $id): bool
    {

        if (!isset($id)){
            return false;
        }

        $db = $this->conn->getConnection();

        $query = "SELECT is_valid FROM user_payment where user_id = :user_id";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $is_valid = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($is_valid[0]['is_valid'] == 1) {
                return true;
            } else {
                return false;
            }
        }else {
            return false;
        }

    }

    public function doPayment(bool $isValid)
    {
        if ($isValid === false){
            echo 'Your payment was not successful, subscription is revoked.'.PHP_EOL;
        } elseif ($isValid === true) {
            echo 'Your payment was successful, subscription is renewed.'.PHP_EOL;
        }else {
            echo 'There was a problem, please try again.';
        }
    }
}
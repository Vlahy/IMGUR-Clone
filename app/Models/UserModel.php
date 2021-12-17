<?php

namespace App\Models;

use Config\Database;
use PDO;

class UserModel
{

    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    /**
     * Method for registering users
     *
     * @param $data
     * @return bool
     */
    public function register($data): bool
    {
        $db = $this->conn->getConnection();
        $query = "INSERT INTO user (username, email, password, api_key, role) VALUES(:username, :email, :password, :api_key, :role)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':username', $data['username']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', $data['password']);
        $stmt->bindValue(':api_key', base64_encode('secret'));
        $stmt->bindValue(':role', 'user');

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method for finding user by username
     *
     * @param $username
     * @return bool
     */
    public function findUserByUsername($username): bool
    {
        $db = $this->conn->getConnection();
        $query = "SELECT * FROM user WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method for finding user by email
     *
     * @param $email
     * @return bool
     */
    public function findUserByEmail($email): bool
    {
        $db = $this->conn->getConnection();
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method for logging in users
     *
     * @param $email
     * @param $password
     * @return false|mixed|object
     */
    public function login($email, $password)
    {
        $db = $this->conn->getConnection();
        $query = "SELECT * FROM user WHERE email = :email";

        $stmt = $db->prepare($query);

        $stmt->bindValue(':email', $email);

        $stmt->execute();

        $row = $stmt->fetchObject();

        if (!empty($row)) {

            $hashedPassword = $row->password;

            if (password_verify($password, $hashedPassword)) {
                return $row;
            } else {
                return false;
            }
        }
        return false;
    }

}
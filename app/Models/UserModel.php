<?php

namespace App\Models;

use App\Models\Enums\UserRoleData as Role;
use Config\Database;

class UserModel implements Role
{

    private Database $conn;

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
        $stmt->bindValue(':role', Role::ROLES[self::USER]);

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

    /**
     * Method for checking if user is logged in
     *
     * @param $id
     * @return bool
     */
    public function isLoggedIn($id): bool
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        return false;

    }

    /**
     * Method for checking if user is author of content
     *
     * @param $id
     * @return bool
     */
    public function isAuthor($id): bool
    {
        if ($this->isLoggedIn($id)) {
            if ($_SESSION['user_id'] === $id) {
                return true;
            } else {
                return false;
            }
        }
        return false;

    }

    /**
     * Method for changing role of user
     *
     * @param $data
     * @return bool
     */
    public function changeRole($data): bool
    {
        $db = $this->conn->getConnection();

        $stmt = $db->prepare("UPDATE user SET role = :role WHERE id = :id");

        $stmt->bindValue(':role', $data['role']);
        $stmt->bindValue(':id', $data['user_id']);

        if ($stmt->execute()){
            return true;
        } else {
            return false;
        }

    }

}
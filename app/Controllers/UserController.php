<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController
{

    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Method for registering users
     *
     * @return void
     */
    public function register()
    {

        //Data that will be accepted from registration form
        $data = [
          'username' => '',
          'email' => '',
          'password' => '',
          'confirmPassword' => '',
          'usernameError' => '',
          'emailError' => '',
          'passwordError' => '',
          'confirmPasswordError' => '',
        ];

        // Checking if request is POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Sanitizing data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Data sent from registration form
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => '',
            ];

            // Regex for username and password checking
            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

            // Username validation
            if(empty($data['username'])){
                $data['usernameError'] = 'Please enter username';
            }elseif (!preg_match($nameValidation, $data['username'])){
                $data['usernameError'] = 'Name can only contain letters and numbers';
            }elseif ($this->userModel->findUserByUsername($data['username'])){
                $data['usernameError'] = 'Username is already taken';
            }

            // Email validation
            if(empty($data['email'])){
                $data['emailError'] = 'Please enter email';
            }elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $data['emailError'] = 'Please enter valid email';
            }elseif ($this->userModel->findUserByEmail($data['email'])){
                $data['emailError'] = 'Email is already taken';
            }

            // Password validation
            if (empty($data['password'])){
                $data['passwordError'] = 'Please enter password';
            }elseif (strlen($data['password']) < 8){
                $data['passwordError'] = 'Password must be at least eight characters long';
            }elseif (!preg_match($passwordValidation, $data['password'])){
                $data['passwordError'] = 'Password must contain at least one number';
            }

            // Checking password confirmation
            if (empty($data['confirmPassword'])){
                $data['confirmPasswordError'] = 'Please confirm password';
            }elseif($data['password'] != $data['confirmPassword']){
                $data['confirmPasswordError'] = 'Passwords do not match';
            }

            // Checking if there are no errors, if true it will try to insert data in database
            if (empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])){

                // Hashing password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)){
                    header('location: /login');
                }else {
                    die([
                        'error' => 'Something went wrong'
                    ]);
                }
            }

        }

        // Including View page
        include __DIR__ . "../../Views/RegisterView.php";
    }

}

<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'quant-zadatak';

$id = $_SESSION['user_id'] ?? basename($_SERVER['REQUEST_URI']);

const REGISTER_URL = 'http://localhost/users/register';
const LOGIN_URL = 'http://localhost/users/login';
const LOGOUT_URL = 'http://localhost/users/logout';
define('PROFILE_URL', 'http://localhost/users/profile/' . $id);
const HOME_URL = 'http://localhost/';
const SUBSCRIBE_PAGE_URL = HOME_URL . 'users/subscriptionForm';
const SUBSCRIBE_FORM_SUBMIT = HOME_URL . 'users/subscriptionFormSubmit';
const CANCEL_SUBSCRIPTION = HOME_URL . 'users/cancelSubscription';
const CHANGE_SUBSCRIPTION_TYPE = HOME_URL . 'users/changeSubscription';

define('HEADER', $_SERVER['DOCUMENT_ROOT'] . '/../app/Helpers/header.php');
define('NAVIGATION', $_SERVER['DOCUMENT_ROOT'] . '/../app/Helpers/navigation.php');
define('FOOTER', $_SERVER['DOCUMENT_ROOT'] . '/../app/Helpers/footer.php');
define('PAGE_NAVIGATION', $_SERVER['DOCUMENT_ROOT'] . '/../app/Helpers/pageNavigation.php');
define('NOT_FOUND', $_SERVER['DOCUMENT_ROOT'] . '/../app/Views/404.php');

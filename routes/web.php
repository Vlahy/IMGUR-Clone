<?php

use Bramus\Router\Router;

$router = new Router();

$router->setBasePath('/');

// Custom 404 Handler
$router->set404(function () {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: application/json');

    $jsonArray = array();
    $jsonArray['status'] = "404";
    $jsonArray['status_text'] = "Route not defined";

    echo json_encode($jsonArray);
});


$router->get('/', function () {
    require_once '../config/config.php';
    require_once '../app/Views/WelcomeView.php';
});

$router->match('GET|POST','/users/register', 'App\Controllers\AuthController@register');

$router->match('GET|POST', '/users/login', 'App\Controllers\AuthController@login');

$router->get('/users/logout', 'App\Controllers\AuthController@logout');

$router->get('/dashboard', function () {
    require_once '../config/config.php';
    require_once HEADER;
    require_once NAVIGATION;
    if (isset($_SESSION['user_id'])){
        echo json_encode($_SESSION);
    }
});

$router->get('/users/profile', 'App\Controllers\UserController@show');

$router->run();

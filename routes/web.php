<?php

require_once '../vendor/autoload.php';

use Bramus\Router\Router;
require_once '../app/Controllers/TestController.php';
$router = new Router();

//$router->setBasePath('/');

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
});


$router->get('/test', 'App\Controllers\TestController@show');

$router->get('/bla', function () {
    echo 'hello from something';
});

$router->run();

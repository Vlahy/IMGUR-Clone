<?php

require __DIR__ . '../vendor/autoload.php';

use Bramus\Router\Router;

$router = new Router();

$router->setBasePath('/');

// Custom 404 Handler
$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: application/json');

    $jsonArray = array();
    $jsonArray['status'] = '404';
    $jsonArray['status_text'] = 'Route not defined';

    echo json_encode($jsonArray);
});

// Setting header for GET methods
$router->before('GET', '/.*', function () {
    header('Content-Type: application/json');
});

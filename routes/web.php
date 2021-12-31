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

$router->get('/users/profile/{id}', 'App\Controllers\GalleryController@index');

$router->get('/users/gallery/{id}', 'App\Controllers\GalleryController@show');

$router->get('/users/image/{id}', 'App\Controllers\ImageController@show');

$router->post('/users/image/delete/{id}', 'App\Controllers\ImageController@delete');

$router->post('/users/image/nsfw/{id}', 'App\Controllers\ImageController@setImageAsNsfw');

$router->post('/users/image/hidden/{id}', 'App\Controllers\ImageController@setImageAsHidden');

$router->post('/users/gallery/delete/{id}', 'App\Controllers\GalleryController@delete');

$router->post('/users/gallery/nsfw/{id}', 'App\Controllers\GalleryController@setGalleryAsNsfw');

$router->post('/users/gallery/hidden/{id}', 'App\Controllers\GalleryController@setGalleryAsHidden');

$router->post('/users/gallery/update', 'App\Controllers\GalleryController@update');

$router->post('/users/image/update', 'App\Controllers\ImageController@update');

$router->post('/users/gallery/comment', 'App\Controllers\CommentController@storeGalleryComment');

$router->post('/users/image/comment', 'App\Controllers\CommentController@storeImageComment');

$router->before('GET|POST','/admin/.*', function () {
    if (!isset($_SESSION['user']) && $_SESSION['role'] != 'admin') {
        header('Location: /');
        exit();
    }
});

$router->get('/admin/panel', 'App\Controllers\AdminController@listLoggerData');

$router->post('/admin/changeRole', 'App\Controllers\AdminController@changeRole');

$router->run();

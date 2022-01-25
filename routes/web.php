<?php

use App\Controllers\GalleryController;
use App\Controllers\ImageController;
use Bramus\Router\Router;
use Config\Database;
use DI\Container;

Database::connection();

$container = new Container();

$router = new Router();

$router->setBasePath('/');

// Custom 404 Handler
$router->set404(function () {
    include NOT_FOUND;
});

$router->get('/', function () use ($container) {
    $container->get(ImageController::class)->listAllImages();
});

$router->match('GET|POST','/users/register', 'App\Controllers\AuthController@register');

$router->match('GET|POST', '/users/login', 'App\Controllers\AuthController@login');

$router->get('/users/logout', 'App\Controllers\AuthController@logout');

$router->get('/users/profile/{id}', function ($id) use ($container) {
    $container->get(GalleryController::class)->index($id);
});

$router->get('/users/gallery/{id}', function ($id) use ($container) {
    $container->get(GalleryController::class)->show($id);
});

$router->get('/users/image/{id}', function ($id) use ($container) {
    $container->get(ImageController::class)->show($id);
});

$router->post('/users/image/delete/{id}', function ($id) use ($container) {
    $container->get(ImageController::class)->delete($id);
});

$router->post('/users/image/nsfw/{id}', function ($id) use ($container) {
    $container->get(ImageController::class)->setImageAsNsfw($id);
});

$router->post('/users/image/hidden/{id}', function ($id) use ($container) {
    $container->get(ImageController::class)->setImageAsHidden($id);
});

$router->post('/users/gallery/add' , function () use ($container) {
    $container->get(GalleryController::class)->store();
});

$router->post('/users/image/add', function () use ($container) {
    $container->get(ImageController::class)->store();
});

$router->get('/users/gallery/delete/{id}', function ($id) use ($container) {
    $container->get(GalleryController::class)->delete($id);
});

$router->get('/users/gallery/nsfw/{id}', function ($id) use ($container) {
    $container->get(GalleryController::class)->setGalleryAsNsfw($id);
});

$router->get('/users/gallery/hidden/{id}', function ($id) use ($container) {
    $container->get(GalleryController::class)->setGalleryAsHidden($id);
});

$router->get('/users/gallery/update', function () use ($container) {
    $container->get(GalleryController::class)->update();
});

$router->post('/users/image/update', function () use ($container) {
    $container->get(ImageController::class)->update();
});

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

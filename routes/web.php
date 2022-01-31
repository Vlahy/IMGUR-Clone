<?php

use App\Controllers\AuthController;
use App\Controllers\GalleryController;
use App\Controllers\ImageController;
use App\Controllers\SubscriptionController;
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

$router->match('GET|POST', '/users/register', function () use ($container) {
    $container->get(AuthController::class)->register();
});

$router->match('GET|POST', '/users/login', function () use ($container) {
    $container->get(AuthController::class)->login();
});

$router->get('/users/logout', function () use ($container) {
    $container->get(AuthController::class)->logout();
});

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

$router->post('/users/gallery/delete/{id}', function ($id) use ($container) {
    $container->get(GalleryController::class)->delete($id);
});

$router->post('/users/gallery/nsfw/{id}', function ($id) use ($container) {
    $container->get(GalleryController::class)->setGalleryAsNsfw($id);
});

$router->post('/users/gallery/hidden/{id}', function ($id) use ($container) {
    $container->get(GalleryController::class)->setGalleryAsHidden($id);
});

$router->post('/users/gallery/update', function () use ($container) {
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

$router->get('/users/subscriptionForm', function () use ($container) {
    $container->get(SubscriptionController::class)->create();
});

$router->post('/users/subscriptionFormSubmit', function () use ($container) {
    $container->get(SubscriptionController::class)->store();
});

$router->post('/users/cancelSubscription', function () use ($container) {
    $container->get(SubscriptionController::class)->cancelSubscription();
});

$router->post('/users/changeSubscription', function () use ($container) {
    $container->get(SubscriptionController::class)->changeSubscriptionType();
});

$router->run();

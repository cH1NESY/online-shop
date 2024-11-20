<?php

require_once "./../core/Autoload.php";

use Controller\BasketController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use core\app;
use core\Autoload;
use Request\AddProductInBasketRequest;
use Request\AddProductInFavorite;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;

$logger = new \Service\Logger\LoggerFileService();
try {


    Autoload::registrate("/var/www/html/src/");
    $app = new App($logger);

    $app->addGetRoute('/login', UserController::class, 'getRegistrateForm');
    $app->addPostRoute('/login', UserController::class, 'login', LoginRequest::class);

    $app->addGetRoute('/registration', UserController::class, 'getRegistrateForm');
    $app->addPostRoute('/registration', UserController::class, 'registrate', RegistrateRequest::class );

    $app->addGetRoute('/catalog', ProductController::class, 'showProducts');

    $app->addGetRoute('/add_product', BasketController::class, 'getAddProductForm');
    $app->addPostRoute('/add_product', BasketController::class, 'addProduct', AddProductInBasketRequest::class );

    $app->addGetRoute('/basket', BasketController::class, 'showProductsInBasket');

    $app->addGetRoute('/order', OrderController::class, 'showProductsReadyToOrder');
    $app->addPostRoute('/order', OrderController::class, 'createOrder', OrderRequest::class );

    $app->addPostRoute('/add_favorite', FavoriteController::class, 'addProduct', AddProductInFavorite::class );

    $app->addGetRoute('/favorite', FavoriteController::class, 'showProductsInFavorite');
    $app->addPostRoute('/favorite', FavoriteController::class, 'deleteProduct', AddProductInFavorite::class );

    $app->run();
}
catch (\Throwable $throwable)
{
    $throwable->getMessage();
}
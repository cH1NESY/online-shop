<?php

require_once "./../core/Autoload.php";
use core\app;
use core\Autoload;

use Request\AddProductInBasketRequest;
use Request\OrderRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Request\AddProductInFavorite;

use Controller\UserController;
use Controller\OrderController;
use Controller\BasketController;
use Controller\ProductController;
use Controller\FavoriteController;

Autoload::registrate("/var/www/html/src/");
$app = new App();

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
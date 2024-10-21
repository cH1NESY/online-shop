<?php

require_once "./../core/Autoload.php";
use core\app;
use core\Autoload;

Autoload::registrate("/var/www/html/src/");
$app = new App();

$app->addRoute('/login', 'GET', 'Controller\UserController', 'getRegistrateForm');
$app->addRoute('/login', 'POST', 'Controller\UserController', 'login');

$app->addRoute('/registration', 'GET', 'Controller\UserController', 'getRegistrateForm');
$app->addRoute('/registration', 'POST', 'Controller\UserController', 'registrate');

$app->addRoute('/catalog', 'GET', 'Controller\ProductController', 'showProducts');

$app->addRoute('/add_product', 'GET', 'Controller\BasketController', 'getAddProductForm');
$app->addRoute('/add_product', 'POST', 'Controller\BasketController', 'addProduct');

$app->addRoute('/basket', 'GET', 'Controller\BasketController', 'showProductsInBasket');

$app->addRoute('/order', 'GET', 'Controller\OrderController', 'showProductsReadyToOrder');
$app->addRoute('/order', 'POST', 'Controller\OrderController', 'createOrder');

$app->addRoute('/add_favorite', 'POST', 'Controller\FavoriteController', 'addProduct');
$app->addRoute('/favorite', 'GET', 'Controller\FavoriteController', 'showProductsInFavorite');
$app->addRoute('/favorite', 'POST', 'Controller\FavoriteController', 'deleteProduct');

$app->run();
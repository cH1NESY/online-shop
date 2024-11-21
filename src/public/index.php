<?php

require_once "./../core/Autoload.php";

use Controller\BasketController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use core\app;
use core\Autoload;
use core\Container;
use Request\AddProductInBasketRequest;
use Request\AddProductInFavorite;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;




    Autoload::registrate("/var/www/html/src/");
    $container = new \core\Container();
    $logger = new \Service\Logger\LoggerFileService();


    $container->set(UserController::class, function (Container $container)
    {
        $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
        $user = new \Model\User();

        return new UserController($authService,$user);
    });

    $container->set(ProductController::class, function (Container $container)
    {
        $product = new \Model\Product();
        $authService = $container->get(\Service\Auth\AuthServiceInterface::class);

        return new ProductController($product,$authService);
    });

    $container->set(OrderController::class, function (Container $container)
    {
        $orderService = new \Service\OrderService();
        $authService = $container->get(\Service\Auth\AuthServiceInterface::class);

       return new OrderController($orderService,$authService);
    });

    $container->set(FavoriteController::class, function (Container $container)
    {


        $userFav = new \Model\UserFavorites();
        $favorite = new \Service\FavoriteService();
        $authService = $container->get(\Service\Auth\AuthServiceInterface::class);


        return new FavoriteController($userFav, $favorite,$authService);
    });

    $container->set(BasketController::class, function (Container $container)
    {
        $basketService = new \Service\BasketService();
        $userProduct = new \Model\UserProduct();
        $authService = $container->get(\Service\Auth\AuthServiceInterface::class);

        return new BasketController($basketService,$userProduct,$authService);
    });

    $container->set(\Service\Logger\LoggerServiceInterface::class, function ()
    {
        return new \Service\Logger\LoggerFileService();
    });

    $container->set(\Service\Auth\AuthServiceInterface::class, function ()
    {
        return new \Service\Auth\AuthSessionService();
    });

    $app = new App($logger, $container);
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


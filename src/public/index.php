<?php

require_once "./../../vendor/autoload.php";


use Ch1nesy\MyCore\App;
use Ch1nesy\MyCore\AuthServiceInterface;
use Ch1nesy\MyCore\Autoload;
use Ch1nesy\MyCore\Container;
use Ch1nesy\MyCore\LoggerServiceInterface;
use Controller\BasketController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\ReviewController;
use Controller\UserController;

use Request\AddProductInBasketRequest;
use Request\AddProductInFavorite;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Request\ReviewRequest;




Autoload::registrate("/var/www/html/src/");
    $container = new Container();
    $logger = new \Service\Logger\LoggerFileService();


    $container->set(UserController::class, function (Container $container)
    {
        $authService = $container->get(AuthServiceInterface::class);
        $user = new \Model\User();

        return new UserController($authService,$user);
    });

    $container->set(ProductController::class, function (Container $container)
    {
        $product = new \Model\Product();
        $orderProduct = new \Model\OrderProduct();
        $review = new \Service\ReviewService();
        $authService = $container->get(AuthServiceInterface::class);

        return new ProductController($product, $orderProduct ,$review,$authService);
    });

    $container->set(OrderController::class, function (Container $container)
    {
        $orderService = new \Service\OrderService();
        $authService = $container->get(AuthServiceInterface::class);

       return new OrderController($orderService,$authService);
    });

    $container->set(FavoriteController::class, function (Container $container)
    {

        $userFav = new \Model\UserFavorites();
        $favorite = new \Service\FavoriteService();
        $authService = $container->get(AuthServiceInterface::class);

        return new FavoriteController($userFav, $favorite,$authService);
    });

    $container->set(BasketController::class, function (Container $container)
    {
        $basketService = new \Service\BasketService();
        $userProduct = new \Model\UserProduct();
        $authService = $container->get(AuthServiceInterface::class);

        return new BasketController($basketService,$userProduct,$authService);
    });

    $container->set(ReviewController::class, function (Container $container)
    {
        $product = new \Model\Product();

        $authService = $container->get(AuthServiceInterface::class);

        return new ReviewController($product,$authService);
    });


$container->set(LoggerServiceInterface::class, function ()
    {
        return new \Service\Logger\LoggerFileService();
    });

    $container->set(AuthServiceInterface::class, function ()
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

    $app->addGetRoute('/order_history', OrderController::class, 'showOrderHistory');

    $app->addPostRoute('/add_review', ReviewController::class, 'getReviewForm', ReviewRequest::class );
    $app->addPostRoute('/review', ReviewController::class, 'addReview', ReviewRequest::class );

    $app->addPostRoute('/info_product', ProductController::class, 'showInfo', AddProductInFavorite::class );
    $app->run();


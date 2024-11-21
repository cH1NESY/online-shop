<?php

namespace core;

use Controller\BasketController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Model\Product;
use Model\User;
use Model\UserFavorites;
use Model\UserProduct;
use Service\Auth\AuthSessionService;
use Service\BasketService;
use Service\FavoriteService;
use Service\OrderService;

class Container
{
    private array $services = [];
    public function get(string $class): object
    {
//        $services = [
//            UserController::class => function()
//            {
//                $authService = new AuthSessionService();
//                $user = new User();
//
//                $object = new UserController($authService ,$user);
//                return $object;
//            },
//            ProductController::class => function()
//            {
//                $product = new Product();
//                $authService = new AuthSessionService();
//
//                $object = new ProductController($product,$authService);
//                return $object;
//            },
//            OrderController::class => function()
//            {
//                $orderService = new OrderService();
//                $authService = new AuthSessionService();
//
//                $object = new OrderController($orderService,$authService);
//                return $object;
//            },
//            FavoriteController::class => function()
//            {
//                $userFav = new UserFavorites();
//                $favorite = new FavoriteService();
//                $authService = new AuthSessionService();
//
//                $object = new FavoriteController($userFav,$favorite,$authService);
//                return $object;
//            },
//            BasketController::class => function()
//            {
//                $basketService = new BasketService();
//                $userProduct = new UserProduct();
//                $authService = new AuthSessionService();
//
//                $object = new BasketController($basketService, $userProduct,$authService);
//                return $object;
//            }
//        ];
        if(!isset($this->services[$class]))
        {
            return new $class();
        }

        $callback = $this->services[$class];

        return $callback($this);
    }

    public function set(string $class, callable $callback)
    {
        $this->services[$class] = $callback;
    }
}
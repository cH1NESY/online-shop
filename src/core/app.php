<?php


namespace core;
use Controller\ProductController;
use Controller\OrderController;
use Controller\BasketController;
use Controller\UserController;
class app
{


    private array $routes = [
        '/login' =>[
            'GET' => [
                'class' => 'Controller\UserController',
                'method' => 'getRegistrateForm'
            ],
            'POST' => [
                'class' => 'Controller\UserController',
                'method' => 'login'
            ]
        ],
        '/registration' =>[
            'GET' => [
                'class' => 'Controller\UserController',
                'method' => 'getRegistrateForm'
            ],
            'POST' => [
                'class' => 'Controller\UserController',
                'method' => 'registrate'
            ]
        ],
        '/catalog' =>[
            'GET' => [
                'class' => 'Controller\ProductController',
                'method' => 'showProducts'
            ]
        ],
        '/add_product' =>[
            'GET' => [
                'class' => 'Controller\BasketController',
                'method' => 'getAddProductForm'
            ],
            'POST' => [
                'class' => 'Controller\BasketController',
                'method' => 'addProduct'
            ]
        ],
        '/basket' =>[
            'GET' => [
                'class' => 'Controller\BasketController',
                'method' => 'showProductsInBasket'
            ]
        ],
        '/order' =>[
            'GET' => [
                'class' => 'Controller\OrderController',
                'method' => 'showProductsReadyToOrder'
            ],
            'POST' => [
                'class' => 'Controller\OrderController',
                'method' => 'createOrder'
            ]
        ]
    ];
    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($requestUri, $this->routes) && array_key_exists($requestMethod, $this->routes[$requestUri])) {

            $classAndMethod = $this->routes[$requestUri][$requestMethod];
            $controllerClass = $classAndMethod['class'];
            $controllerMethod = $classAndMethod['method'];
            $controller = new $controllerClass();

            if (method_exists($controller, $controllerMethod)) {
                $controller->$controllerMethod();
            } else {

                http_response_code(404);
                require_once '../View/404.php';
            }
        } else {

            http_response_code(404);
            require_once '../View/404.php';
        }
    }
}
<?php


require_once './../Controller/UserController.php';
require_once './../Controller/BasketController.php';
require_once './../Controller/ProductController.php';
require_once './../Controller/OrderController.php';


class app
{
    private array $routes = [
        '/login' =>[
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrateForm'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login'
            ]
        ],
        '/registration' =>[
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrateForm'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate'
            ]
        ],
        '/catalog' =>[
            'GET' => [
                'class' => 'ProductController',
                'method' => 'showProducts'
            ]
        ],
        '/add_product' =>[
            'GET' => [
                'class' => 'BasketController',
                'method' => 'getAddProductForm'
            ],
            'POST' => [
                'class' => 'BasketController',
                'method' => 'addProduct'
            ]
        ],
        '/basket' =>[
            'GET' => [
                'class' => 'BasketController',
                'method' => 'showProductsInBasket'
            ]
        ],
        '/order' =>[
            'GET' => [
                'class' => 'OrderController',
                'method' => 'showProductsReadyToOrder'
            ],
            'POST' => [
                'class' => 'OrderController',
                'method' => 'createOrder'
            ]
        ]
    ];
    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($requestUri, $this->routes) && array_key_exists($requestMethod, $this->routes[$requestUri])) {

            $route = $this->routes[$requestUri][$requestMethod];
            $controllerClass = $route['class'];
            $controllerMethod = $route['method'];
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
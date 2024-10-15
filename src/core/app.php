<?php

//use Controller\ProductController;
//use Controller\OrderController;
//use Controller\BasketController;
//use Controller\UserController;

$autholoadController = function (string $controllerName)
{
   $path =  "./../Controller/$controllerName.php";
   if(file_exists($path))
   {
       require_once $path;
       return true;
   }
   return false;
};

$autholoadModel = function (string $modelName)
{
    $path = "./../Model/$modelName.php";
    if(file_exists($path))
    {
        require_once $path;
        return true;
    }
    return false;
};

    spl_autoload_register($autholoadController);
    spl_autoload_register($autholoadModel);

//$autholoadController = function (string $controllerName)
//{
//   $path = '/' . str_replace('\\' , '/' , $controllerName) . '.php';
//
//   if(file_exists($path))
//   {
//       require_once $path;
//       return true;
//   }
//   return false;
//};
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
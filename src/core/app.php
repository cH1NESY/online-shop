<?php


namespace core;
use Controller\ProductController;
use Controller\OrderController;
use Controller\BasketController;
use Controller\UserController;
use Request\Request;

class app
{


    private array $routes = [];

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

                $request = new Request($requestUri,$requestMethod, $_POST);

                $controller->$controllerMethod($request);
            } else {

                http_response_code(404);
                require_once '../View/404.php';
            }
        } else {

            http_response_code(404);
            require_once '../View/404.php';
        }
    }

    public function addRoute(string $route, string $method, string $class, string $methodName)
    {
        $this->routes[$route][$method] = ['class'=> $class, 'method' => $methodName];
    }
}
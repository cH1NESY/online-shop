<?php


namespace core;
use Controller\ProductController;
use Controller\OrderController;
use Controller\BasketController;
use Controller\UserController;
use Request\Request;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Request\OrderRequest;
use Request\AddProductInFavorite;
use Request\AddProductInBasketRequest;
class app
{


    private array $routes = [];

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $route = $this->routes[$requestUri];

            if (isset($route[$requestMethod])) {
                $controllerClassName = $route[$requestMethod]['class'];
                $method = $route[$requestMethod]['method'];
                $requestClass = $route[$requestMethod]['request'];

                $class = new $controllerClassName();
                try {


                    if(empty($requestClass)) {
                        return $class->$method();
                    }else{
                        $request = new $requestClass($requestUri, $requestMethod, $_POST);
                        return $class->$method($request);
                    }
                }catch (\Throwable $exception){
                    $message = $exception->getMessage();
                    $file = $exception->getFile();
                    $line = $exception->getLine();


                    $log = date('Y-m-d H:i:s') . $message . PHP_EOL . $file . PHP_EOL . $line . PHP_EOL;
                    file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);


                    http_response_code(500);
                    require_once "./../View/404.php";
                }
            } else {
                echo "$requestMethod не поддерживается для $requestUri";
            }
        } else {
            http_response_code(404);
            require_once "./../View/404.php";
        }
    }


    public function addPostRoute(string $route, string $class, string $methodName,string $requestClass)
    {
        $this->routes[$route]['POST'] = ['class'=> $class, 'method' => $methodName, 'request' => $requestClass];
    }
    public function addGetRoute(string $route, string $class, string $methodName,string $requestClass = null)
    {
        $this->routes[$route]['GET'] = ['class'=> $class, 'method' => $methodName, 'request' => $requestClass];
    }

}
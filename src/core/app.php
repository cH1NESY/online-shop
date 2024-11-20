<?php


namespace core;
use Service\Logger\LoggerServiceInterface;

class app
{


    private array $routes = [];
    private LoggerServiceInterface $logger;

    public function __construct(LoggerServiceInterface $logger)
    {
        $this->logger = $logger;
    }

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

                    $this->logger->errors( "Произошла ошибка при обработке",
                        ['message' => $exception->getMessage(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine()]);


                    http_response_code(500);
                    require_once "./../View/500.php";
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
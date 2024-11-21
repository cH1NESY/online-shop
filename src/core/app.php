<?php


namespace core;
use Controller\BasketController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Model\OrderProduct;
use Model\Product;
use Model\User;
use Model\UserFavorites;
use Model\UserProduct;
use core\Container;
use Service\Auth\AuthSessionService;
use Service\BasketService;
use Service\FavoriteService;
use Service\Logger\LoggerServiceInterface;
use Service\OrderService;

class app
{


    private array $routes = [];
    private LoggerServiceInterface $logger;
    private Container $container;

    public function __construct(LoggerServiceInterface $logger, Container $container)
    {
        $this->logger = $logger;
        $this->container = $container;
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



                $class = $this->container->get($controllerClassName);
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


//    public function getObject(string $class)
//    {
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
//
//        $callback = $services[$class];
//        return $callback();
//    }
}
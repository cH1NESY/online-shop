<?php
    $requestUri = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    require_once './../Controller/UserController.php';
    require_once './../Controller/BasketController.php';
    require_once './../Controller/ProductController.php';


    switch ($requestUri){
        case '/login':
            if($requestMethod === 'GET') {

                $userController = new UserController();
                $userController->getRegistrateForm();
            }elseif ($requestMethod === 'POST') {

                $userController = new UserController();
                $userController->login();
            }else {
                echo "Такой метод не поддерживается";
            }
            break;
        case '/registration':
            if($requestMethod === 'GET') {

                $userController = new UserController();
                $userController->getRegistrateForm();
            }elseif ($requestMethod === 'POST') {

                $userController = new UserController();
                $userController->registrate();
            }else {
                echo "Такой метод не поддерживается";
            }
            break;
        case '/catalog':
            if ($requestMethod === 'GET') {
               $productController = new ProductController();
               $productController->showProducts();
            }
            else {
                echo "Такой метод не поддерживается";
            }
            break;
        case '/add_product':
            if($requestMethod === 'GET') {
                $basketController = new BasketController();
                $basketController->getAddProductForm();
            }elseif ($requestMethod === 'POST') {
                $basketController = new BasketController();
                $basketController->checkProduct();
            }else {
                echo "Такой метод не поддерживается";
            }
            break;
        case '/basket':
            if($requestMethod === 'GET') {
                $basketController = new BasketController();
                $basketController->showProductsInBasket();
            }
            else {
                echo "Такой метод не поддерживается";
            }
            break;
        default:
            http_response_code(404);
            require_once './../View/404.php';
            break;
    }
?>
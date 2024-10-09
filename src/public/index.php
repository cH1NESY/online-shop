<?php
    $requestUri = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestUri){
        case '/login':
            if($requestMethod === 'GET') {
                require_once './get_registration.php';
            }elseif ($requestMethod === 'POST') {
                require_once './handle_login.php';
            }else {
                echo "Такой метод не поддерживается";
            }
            break;
        case '/registration':
            if($requestMethod === 'GET') {
                require_once './get_registration.php';
            }elseif ($requestMethod === 'POST') {
                require_once './handle_registration.php';
            }else {
                echo "Такой метод не поддерживается";
            }
            break;
        case '/catalog':
            if ($requestMethod === 'GET') {
                require_once './catalog.php';
            }
            else {
                echo "Такой метод не поддерживается";
            }
            break;
        case '/add_product':
            if($requestMethod === 'GET') {
                require_once './get_add_product.php';
            }elseif ($requestMethod === 'POST') {
                require_once './handle_add_product.php';
            }else {
                echo "Такой метод не поддерживается";
            }
            break;
        case '/basket':
            if($requestMethod === 'GET') {
                require_once './basket.php';
            }
            else {
                echo "Такой метод не поддерживается";
            }
            break;
        default:
            http_response_code(404);
            require_once './404.php';
            break;
    }
?>
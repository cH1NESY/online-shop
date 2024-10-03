<?php
    $requestUri = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER['REQUEST_METHOD'];
   /*f($requestUri === '/login') {
        if($requestMethod === 'GET') {
            require_once './get_registration.php';
        }elseif ($requestMethod === 'POST') {
            require_once './handle_login.php';
        }
    } elseif ($requestUri === '/registration') {
       if($requestMethod === 'GET') {
           require_once './get_registration.php';
       }elseif ($requestMethod === 'POST') {
           require_once './handle_registration.php';
       }
    }elseif ($requestUri === '/catalog'){
        require_once './catalog.php';
    }
    else{
        http_response_code(404);
        require_once './404.php';
    }*/
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
            require_once './catalog.php';
            break;
        case '/add_product':
            if($requestMethod === 'GET') {
                require_once './get_add_product.php';
            }elseif ($requestMethod === 'POST') {
                require_once './handle_add_product.php';
            }else {
                echo "Такой метод не поддерживается";
            }
        default:
            http_response_code(404);
            require_once './404.php';
            break;
    }
?>
<?php
    $requestUri = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    if($requestUri === '/login') {
        if($requestMethod === 'GET') {
            require_once './login';
        }elseif ($requestMethod === 'POST') {
            require_once './handle-login';
        }
    } elseif ($requestUri === '/handle-login') {
        require_once './handle-login';
    }else{
        http_response_code(404);
    }

?>
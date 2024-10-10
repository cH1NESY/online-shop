<?php

class ProductController
{
    public function showProducts()
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }

        require_once "./../Model/Product.php";
        $product = new Product();
        $products = $product->getProducts();
        require_once "./../View/catalog.php";
        return $products;

    }
}
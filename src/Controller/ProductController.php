<?php
namespace Controller;
use Model\Product;
class ProductController
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }
    public function showProducts()
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }

        $products = $this->product->getProducts();


        require_once "./../View/catalog.php";


    }
}
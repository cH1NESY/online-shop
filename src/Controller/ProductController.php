<?php
namespace Controller;
use Model\Product;
use Service\AuthService;

class ProductController
{
    private Product $product;
    private AuthService $authService;
    public function __construct()
    {
        $this->product = new Product();
        $this->authService = new AuthService();
    }
    public function showProducts()
    {

        if(!$this->authService->check()){
            header('Location: /login');
        }

        $products = $this->product->getProducts();


        require_once "./../View/catalog.php";


    }
}
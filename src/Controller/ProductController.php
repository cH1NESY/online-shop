<?php
namespace Controller;
use Model\Product;
use Service\Auth\AuthServiceInterface;

class ProductController
{
    private Product $product;
    private AuthServiceInterface $authService;
    public function __construct( Product $product, AuthServiceInterface $authService)
    {
        $this->product = $product;
        $this->authService = $authService;
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
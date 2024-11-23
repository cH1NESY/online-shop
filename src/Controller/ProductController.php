<?php
namespace Controller;
use Model\Product;
use Request\AddProductInFavorite;
use Service\Auth\AuthServiceInterface;
use Service\ReviewService;
use Model\Review;

class ProductController
{
    private Product $product;
    private ReviewService $reviewService;
    private AuthServiceInterface $authService;
    public function __construct( Product $product, ReviewService $reviewService,AuthServiceInterface $authService)
    {
        $this->product = $product;
        $this->reviewService = $reviewService;
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

    public function showInfo(AddProductInFavorite $request)
    {

        if(!$this->authService->check()){
            header('Location: /login');
        }
        $productId = $request->getProductId();
        $product = $this->product->getProductsByProductId($productId);

        $reviews = Review::getByProductId($productId);

        $avg = $this->reviewService->getAvgRating($reviews);

        require_once "./../View/infoProduct.php";

    }
}
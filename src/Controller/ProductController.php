<?php
namespace Controller;
use Model\OrderProduct;
use Model\Product;
use Request\AddProductInFavorite;
use Service\Auth\AuthServiceInterface;
use Service\ReviewService;
use Model\Review;

class ProductController
{
    private Product $product;
    private OrderProduct $orderProduct;
    private ReviewService $reviewService;
    private AuthServiceInterface $authService;
    public function __construct( Product $product,OrderProduct $orderProduct ,ReviewService $reviewService,AuthServiceInterface $authService)
    {
        $this->product = $product;
        $this->orderProduct = $orderProduct;
        $this->reviewService = $reviewService;
        $this->authService = $authService;

    }
    public function showProducts()
    {

        $products = $this->product->getProducts();


        require_once "./../View/catalog.php";

    }

    public function showInfo(AddProductInFavorite $request)
    {
        $authFlag = false;
        if($this->authService->check()){
            $authFlag = true;
            $userId = $this->authService->getCurrentUser()->getId();
            $products = OrderProduct::getOrderAndProductsByUser($userId);
        }


            $productId = $request->getProductId();
            $product = $this->product->getProductsByProductId($productId);

            $reviews = Review::getByProductId($productId);




            $avg = $this->reviewService->getAvgRating($reviews);

            require_once "./../View/infoProduct.php";

    }
}
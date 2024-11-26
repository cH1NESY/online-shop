<?php

namespace Controller;

use DTO\AddReviewDTO;
use Model\Product;
use Model\Review;
use Request\ReviewRequest;
use Service\Auth\AuthServiceInterface;
use Service\ReviewService;

class ReviewController
{
    private Product $product;
    private AuthServiceInterface $authService;
    public function __construct( Product $product, AuthServiceInterface $authService)
    {
        $this->product = $product;
        $this->authService = $authService;
    }
    public function getReviewForm(ReviewRequest $reviewRequest)
    {
        if(!$this->authService->check()){
            header('Location: /login');
        }
        $productId = $reviewRequest->getProductId();
        $products = $this->product->getProducts();
        require_once "./../View/review.php";
    }

    public function addReview(ReviewRequest $reviewRequest)
    {
        if(!$this->authService->check()){
            header('Location: /login');
        }
        $productId = $reviewRequest->getProductId();
        $userId = $this->authService->getCurrentUser()->getId();
        $review = $reviewRequest->getReview();
        $rating = $reviewRequest->getRating();
        $date = date('Y-m-d H:i:s');
        Review::addReview($productId, $userId, $review, $rating, $date);
        header('Location: /catalog');

    }



}
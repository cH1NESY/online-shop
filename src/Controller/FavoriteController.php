<?php

namespace Controller;
use DTO\FavoriteDTO;
use Model\UserFavorites;
use Model\Product;
use Request\AddProductInBasketRequest;
use Request\AddProductInFavorite;
use Service\FavoriteService;

class FavoriteController
{
    private UserFavorites $userFavorites;
    private FavoriteService $favoriteService;

    public function __construct( )
    {
        $this->userFavorites = new UserFavorites();
        $this->favoriteService = new FavoriteService();

    }
    public function addProduct(AddProductInFavorite $request)
    {
        session_start();
        $userId = $_SESSION['user_id'];

            $productId = $request->getProductId();

            $dto = new FavoriteDTO($userId, $productId);
            $this->favoriteService->addProduct($dto);
            header('Location: /favorite');


    }

    public function deleteProduct()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'];
        $this->userFavorites->deleteProduct($userId, $productId);
        header('Location: /catalog');
    }

    public function showProductsInFavorite()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }


        $dto = new FavoriteDTO($userId);
        $products = $this->favoriteService->showProducts($dto);


        require_once "./../View/favorite.php";


    }

}
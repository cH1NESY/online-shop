<?php

namespace Controller;
use DTO\FavoriteDTO;
use Model\UserFavorites;
use Model\Product;
use Request\AddProductInBasketRequest;
use Request\AddProductInFavorite;
use Service\AuthService;
use Service\FavoriteService;

class FavoriteController
{
    private UserFavorites $userFavorites;
    private FavoriteService $favoriteService;

    private AuthService $authService;

    public function __construct( )
    {
        $this->userFavorites = new UserFavorites();
        $this->favoriteService = new FavoriteService();
        $this->authService = new AuthService();

    }
    public function addProduct(AddProductInFavorite $request)
    {

        $userId =  $this->authService->getCurrentUser()->getId();

            $productId = $request->getProductId();

            $dto = new FavoriteDTO($userId, $productId);
            $this->favoriteService->addProduct($dto);
            header('Location: /favorite');


    }

    public function deleteProduct(AddProductInFavorite $request)
    {

        $userId = $this->authService->getCurrentUser()->getId();
        $productId = $request->getProductId();
        $this->userFavorites->deleteProduct($userId, $productId);
        header('Location: /catalog');
    }

    public function showProductsInFavorite()
    {

        $userId = $this->authService->getCurrentUser()->getId();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }


        $dto = new FavoriteDTO($userId);
        $products = $this->favoriteService->showProducts($dto);


        require_once "./../View/favorite.php";


    }

}
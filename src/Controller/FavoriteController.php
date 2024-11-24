<?php

namespace Controller;
use DTO\FavoriteDTO;
use Model\UserFavorites;
use Request\AddProductInFavorite;
use Service\Auth\AuthServiceInterface;

use Service\FavoriteService;

class FavoriteController
{
    private UserFavorites $userFavorites;
    private FavoriteService $favoriteService;

    private AuthServiceInterface $authService;

    public function __construct( UserFavorites $userFavorites, FavoriteService $favoriteService, AuthServiceInterface $authService )
    {
        $this->userFavorites = $userFavorites;
        $this->favoriteService = $favoriteService;
        $this->authService = $authService;

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
        if($this->authService->check()){
            header('Location: /login');
        }


        $dto = new FavoriteDTO($userId);
        $products = $this->favoriteService->showProducts($dto);


        require_once "./../View/favorite.php";


    }

}
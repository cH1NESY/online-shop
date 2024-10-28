<?php

namespace Service;

use DTO\FavoriteDTO;
use Model\Product;
use Model\UserFavorites;

class FavoriteService
{
    private UserFavorites $userFavorites;
    private Product $product;
    public  function __construct(UserFavorites $userFavorites, Product $product)
    {
        $this->userFavorites = $userFavorites;
        $this->product = $product;

    }
    public function showProducts(FavoriteDTO $favoriteDTO)
    {

        $productsInFavorite = $this->userFavorites->getProductsByUserId($favoriteDTO->getUserId());

        foreach($productsInFavorite as $productInFavorite){
            $product = $this->product->getProductsByProductId($productInFavorite->getProduct()->getId());

            $products[] = $product;
        }
    }

    public function addProduct(FavoriteDTO $favoriteDTO)
    {
        $res = $this->userFavorites->getByUserIdAndByProductId($favoriteDTO->getUserId(), $favoriteDTO->getProductId());

        if(empty($res)){
            $this->userFavorites->addProductInFavorite($favoriteDTO->getUserId(), $favoriteDTO->getProductId());
        }else{
            $this->userFavorites->deleteProduct($favoriteDTO->getUserId(), $favoriteDTO->getProductId());
        }
    }
}
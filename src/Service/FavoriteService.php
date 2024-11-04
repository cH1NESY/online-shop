<?php

namespace Service;

use DTO\FavoriteDTO;
use Model\Product;
use Model\UserFavorites;

class FavoriteService
{

    public function showProducts(FavoriteDTO $favoriteDTO)
    {

        $productsInFavorite = UserFavorites::getProductsByUserId($favoriteDTO->getUserId());

        foreach($productsInFavorite as $productInFavorite){
            $product = Product::getProductsByProductId($productInFavorite->getProduct()->getId());

            $products[] = $product;
        }
        return $products;
    }

    public function addProduct(FavoriteDTO $favoriteDTO)
    {
        $res = UserFavorites::getByUserIdAndByProductId($favoriteDTO->getUserId(), $favoriteDTO->getProductId());

        if(empty($res)){
            UserFavorites::addProductInFavorite($favoriteDTO->getUserId(), $favoriteDTO->getProductId());
        }else{
            UserFavorites::deleteProduct($favoriteDTO->getUserId(), $favoriteDTO->getProductId());
        }
    }
}
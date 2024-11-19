<?php

namespace Service;

use DTO\AddProductDTO;
use Model\Product;
use Model\UserProduct;

class BasketService
{

    public function addProduct(AddProductDTO $addProductDTO){
        $res = UserProduct::getByUserIdAndByProductId($addProductDTO->getUserId(), $addProductDTO->getProductId());
        if(empty($res)){

            UserProduct::addProductInBasket($addProductDTO->getUserId(), $addProductDTO->getProductId(), $addProductDTO->getAmount());
        }else{
            $amount = $addProductDTO->getAmount();
            $amount += $res->getAmount();

            UserProduct::updateAmount($addProductDTO->getUserId(), $addProductDTO->getProductId(), $amount);
        }
    }
}
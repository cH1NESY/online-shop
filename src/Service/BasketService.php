<?php

namespace Service;

use DTO\AddProductDTO;
use Model\Product;
use Model\UserProduct;

class BasketService
{
    private UserProduct $userProduct;
    public function __construct(UserProduct $userProduct)
    {
        $this->userProduct = $userProduct;
    }
    public function addProduct(AddProductDTO $addProductDTO){
        $res = $this->userProduct->getByUserIdAndByProductId($addProductDTO->getUserId(), $addProductDTO->getProductId());
        if(empty($res)){

            $this->userProduct->addProductInBasket($addProductDTO->getUserId(), $addProductDTO->getProductId(), $addProductDTO->getAmount());
        }else{
            $amount = $addProductDTO->getAmount();
            $amount += $res->getAmount();

            $this->userProduct->updateAmount($addProductDTO->getUserId(), $addProductDTO->getProductId(), $amount);
        }
    }
}
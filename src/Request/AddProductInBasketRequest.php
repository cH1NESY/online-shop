<?php

namespace Request;
use Ch1nesy\MyCore\Request;
use Model\Product;


class AddProductInBasketRequest extends Request
{

    public function getProductId():?string
    {
        return $this->data['product_id'] ?? null;
    }

    public function getAmount():?string
    {
        return $this->data['amount'] ?? null;
    }

    public function validateProduct()
    {
        $errors = [];
        $productId = $this->data['product_id'];
        $products = Product::getProductIdsByProductId($productId);
        $correctId = $products->getId();
        if(empty($productId)) {
            $errors['product_id'] = "id пустой";
        }elseif (empty($correctId)) {
            $errors['product_id'] = "Нет такого id";
        }


        if (!isset($this->data['amount'])) {
            $errors['amount'] = "Поле amount должно быть заполнено";
        }


        return $errors;

    }
}
<?php

namespace Request;
use Model\Product;
use Model\UserProduct;

class AddProductRequest extends Request
{
    private Product $product;
    public function __construct( )
    {

        $this->product = new Product();
    }
    public function getProductId():?string
    {
        return $this->data['productId'] ?? null;
    }

    public function getAmount():?string
    {
        return $this->data['amount'] ?? null;
    }

    public function validateProduct()
    {
        $errors = [];

        if (isset($this->data['productId'])) {
            $productId = $this->data['productId'];
            $products = $this->product->getProductIdsByProductId($productId);

            if($products === false){
                $errors['product_id'] = "Нет такого id";

            }
        } else {
            $errors['product_id'] = "Поле product_id должно быть заполнено";

        }

        if (!isset($this->data['amount'])) {
            $errors['amount'] = "Поле amount должно быть заполнено";
        }


        return $errors;

    }
}
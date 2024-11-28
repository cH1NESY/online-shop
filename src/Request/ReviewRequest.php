<?php

namespace Request;


use Ch1nesy\MyCore\Request;
use Model\OrderProduct;

class ReviewRequest extends Request
{
    public function getProductId()
    {
        return $this->data['product_id'] ?? null;
    }

    public function getReview()
    {
        return $this->data['text'] ?? null;
    }

    public function getRating()
    {
        return $this->data['rating'] ?? null;
    }

    public function validate($userId): array
    {
        $errors = [];

        if (isset($this->data['text'])) {
            $text = ($this->data['text']);
            if (strlen($text) < 3 || strlen($text) > 255) {
                $errors['text'] = "Отзыв должен содержать не меньше 3 символов и не больше 255 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9 ,.]+$/u", $text)) {
                $errors['text'] = "Имя может содержать только буквы и цифры";
            }
        }else{
            $errors ['text'] = "Поле name должно быть заполнено";
        }



        if (isset($this->data['rating'])) {
            $rating = ($this->data['rating']);
            if (strlen($rating) < 1 || strlen($rating) > 3) {
                $errors['rating'] = "rating может содержать не больше 1 цифры после запятой";
            } elseif (!preg_match("/^[0-9 ,.-]+$/u", $rating)) {
                $errors['rating'] = "Rating может содержать только цифры";
            }
        }else {
            $errors ['rating'] = "Поле rating должно быть заполнено";
        }

        if(isset($this->data['product_id'])){
            $productId = ($this->data['product_id']);
            $products = OrderProduct::getOrderAndProductsByUser($userId);
            $flag = false;
            foreach ($products as $product) {
                if($product->getProduct()->getId() == $productId){
                    $flag = true;
                }
            }
            if(!$flag){
                $errors['product_id'] = "Вы не заказывали данный товар";
            }
        }

        return $errors;
    }
}
<?php

namespace Request;

use Ch1nesy\MyCore\Request;

class AddProductInFavorite extends Request
{
    public function getProductId():?int
    {
        return $this->data['product_id'] ?? null;
    }
}
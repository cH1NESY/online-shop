<?php

namespace Request;

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

}
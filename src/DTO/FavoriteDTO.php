<?php

namespace DTO;

class FavoriteDTO
{
    public function __construct(private int $userId, private int $productId = 0){}
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getProductId(): int
    {
        return $this->productId;
    }
}
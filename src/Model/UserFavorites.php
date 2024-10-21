<?php

namespace Model;
use Model\Database;
class UserFavorites extends Database
{

    public function getByUserIdAndByProductId(int $userId, int $productId)
    {

        $stmt = $this->pdo->prepare('SELECT * FROM user_favorites WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();
        return $res;
    }

    public function addProductInFavorite(int $userId, int $productId){

        $stmt = $this->pdo->prepare('INSERT INTO user_favorites (userId, productId) VALUES (:userId, :productId)');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public function deleteProduct(int $userId, int $productId){

        $stmt = $this->pdo->prepare('DELETE FROM user_favorites WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }
    public function getProductsByUserId(int $userId): array
    {

        $stmt = $this->pdo->prepare("SELECT * FROM user_favorites WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $res = $stmt->fetchAll();
        return $res;
    }

}
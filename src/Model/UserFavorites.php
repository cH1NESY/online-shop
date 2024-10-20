<?php

namespace Model;
use Model\Database;
class UserFavorites
{
    private Database $pdo;

    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function getByUserIdAndByProductId(int $userId, int $productId)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare('SELECT * FROM user_favorites WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();
        return $res;
    }

    public function addProductInFavorite(int $userId, int $productId){
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare('INSERT INTO user_favorites (userId, productId) VALUES (:userId, :productId)');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public function deleteProduct(int $userId, int $productId){
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare('DELETE FROM user_favorites WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }
    public function getProductsByUserId(int $userId): array
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("SELECT * FROM user_favorites WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $res = $stmt->fetchAll();
        return $res;
    }

}
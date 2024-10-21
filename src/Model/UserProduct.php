<?php
namespace Model;
//require_once './../Model/Database.php';

use Model\Database;
class UserProduct extends Database
{

    public function getByUserIdAndByProductId(int $userId, int $productId)
    {

        $stmt = $this->pdo->prepare('SELECT * FROM user_products WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();
        return $res;
    }

    public function addProductInBasket(int $userId,int $productId,int $amount)
    {

        $stmt = $this->pdo->prepare("INSERT INTO user_products (userId, productId, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateAmount(int $userId,int $productId,int $amount)
    {

        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE userId = :userId AND productId = :productId");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function getProductsByUserId(int $userId): array
    {

        $stmt = $this->pdo->prepare("SELECT * FROM user_products JOIN products ON user_products.productId = products.id WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $res = $stmt->fetchAll();
        return $res;
    }

    public function deleteProductByUserId(int $userId)
    {

        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);

    }
}
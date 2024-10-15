<?php
namespace Model;
//require_once './../Model/Database.php';

use Model\Database;
class UserProduct
{
    private Database $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function getByUserIdAndByProductId(int $userId, int $productId)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare('SELECT * FROM user_products WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();
        return $res;
    }

    public function addProductInBasket(int $userId,int $productId,int $amount)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->connectToDatabase()->prepare("INSERT INTO user_products (userId, productId, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateAmount(int $userId,int $productId,int $amount)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->connectToDatabase()->prepare("UPDATE user_products SET amount = :amount WHERE userId = :userId AND productId = :productId");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function getProductsByUserId(int $userId): array
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->connectToDatabase()->prepare("SELECT * FROM user_products JOIN products ON user_products.productId = products.id WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $res = $stmt->fetchAll();
        return $res;
    }

    public function deleteProductByUserId(int $userId)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->connectToDatabase()->prepare("DELETE FROM user_products WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);

    }
}
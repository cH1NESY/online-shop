<?php

class UserProduct
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }
    public function getByUserIdAndByProductId(int $userId, int $productId)
    {

        $stmt = $this->pdo->prepare('SELECT * FROM user_products WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();
        return $res;
    }

    public function addProductInBasket(int $userId,int $productId,int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO user_products (userId, productId, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateAmount(int $userId,int $productId,int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE userId = :userId AND productId = :productId");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function getProductsByUserId(int $userId): array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM user_products JOIN products ON user_products.productId = products.id WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $res = $stmt->fetchAll();
        return $res;
    }

    public function deleteProductByUserId(int $userId)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("DELETE FROM user_products WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);

    }
}
<?php

class UserProduct
{
    public function getByUserIdAndByProductId(int $userId, int $productId): array
    {
        $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", "user", "pass");
        $stmt = $pdo->prepare('SELECT * FROM user_products WHERE user_id = :userId AND product_id = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();
        return $res;
    }

    public function addProductInBasket(int $userId,int $productId,int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateAmount(int $userId,int $productId,int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function getProductsByUserId(int $userId): array
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM user_products JOIN products ON user_products.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $res = $stmt->fetchAll();
        return $res;
    }
}
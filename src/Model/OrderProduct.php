<?php


class OrderProduct
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }
    public function addProductInOrder(int $orderId, int $productId, int $amount, int $price)
    {

        $stmt = $this->pdo->prepare("INSERT INTO order_products (orderId, productId, amount, price) 
            VALUES (:orderId, :productId, :amount, :price)");
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount, 'price' => $price]);

    }
}
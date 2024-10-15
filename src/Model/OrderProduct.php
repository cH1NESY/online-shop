<?php
//namespace Model\Database;
require_once './../Model/Database.php';
class OrderProduct
{
    private Database $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function addProductInOrder(int $orderId, int $productId, int $amount, int $price)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->connectToDatabase()->prepare("INSERT INTO order_products (orderId, productId, amount, price) 
            VALUES (:orderId, :productId, :amount, :price)");
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount, 'price' => $price]);

    }
}
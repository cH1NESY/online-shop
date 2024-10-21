<?php
namespace Model;
//require_once './../Model/Database.php';
use Model\Database;
class OrderProduct extends Database
{

    public function addProductInOrder(int $orderId, int $productId, int $amount, int $price)
    {

        $stmt = $this->pdo->prepare("INSERT INTO order_products (orderId, productId, amount, price) 
            VALUES (:orderId, :productId, :amount, :price)");
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount, 'price' => $price]);

    }
}
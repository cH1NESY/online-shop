<?php
namespace Model;
//require_once './../Model/Database.php';
use Model\Database;
class Product extends Database
{

    public function getProducts(): array
    {

        $stmt = $this->pdo->prepare("SELECT *  FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getProductIdsByProductId(int $productId): array |false
    {

        $stmt = $this->pdo->prepare('SELECT id FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $products = $stmt->fetch();
        return $products;
    }
    public function getProductsByProductId(int $productId): array |false
    {

        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $products = $stmt->fetch();
        return $products;
    }
}
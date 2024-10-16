<?php
namespace Model;
//require_once './../Model/Database.php';
use Model\Database;
class Product
{
    private Database $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function getProducts(): array
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("SELECT *  FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getProductsByProductId(int $productId): array |false
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare('SELECT id FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $products = $stmt->fetch();
        return $products;
    }
}
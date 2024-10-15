<?php
//namespace Model\Database;
require_once './../Model/Database.php';
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
}
<?php

class Product
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }
    public function getProducts(): array
    {

        $stmt = $this->pdo->prepare("SELECT *  FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }
}
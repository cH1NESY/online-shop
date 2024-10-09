<?php

class ProductController
{
    public function showProducts()
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }

        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("SELECT *  FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        require_once "./../View/catalog.php";
        return $products;

    }
}
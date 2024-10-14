<?php

class order
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }
    public function createNewOrder($userId, $contactName, $contactNumber, $address)
    {


        $stmt = $this->pdo->prepare("INSERT INTO orders (userId, contactName, contactNumber, address)
            VALUES (:userId, :contactName, :contactNumber, :address)");
        $stmt->execute(['userId' => $userId, 'contactName' => $contactName, 'contactNumber' => $contactNumber, 'address' => $address]);
    }

    public function getOrderIdByUser($userId)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT id FROM orders WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetch();
    }
}
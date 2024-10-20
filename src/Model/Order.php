<?php
//require_once './../Model/Database.php';

namespace Model;
use Model\Database;
class order
{
    private Database $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function createNewOrder($userId, $contactName, $contactNumber, $address)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("INSERT INTO orders (userId, contactName, contactNumber, address) 
        VALUES (:userId, :contactName, :contactNumber, :address)");

        $stmt->execute(['userId' => $userId, 'contactName' => $contactName, 'contactNumber' => $contactNumber, 'address' => $address]);
    }

    public function getOrderIdByUser($userId)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("SELECT id FROM orders WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetch();
    }
}
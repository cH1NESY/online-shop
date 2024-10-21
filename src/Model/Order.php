<?php
//require_once './../Model/Database.php';

namespace Model;
use Model\Database;
class Order extends Database
{

    public function createNewOrder($userId, $contactName, $contactNumber, $address)
    {

        $stmt = $this->pdo->prepare("INSERT INTO orders (userId, contactName, contactNumber, address) 
        VALUES (:userId, :contactName, :contactNumber, :address)");

        $stmt->execute(['userId' => $userId, 'contactName' => $contactName, 'contactNumber' => $contactNumber, 'address' => $address]);
    }

    public function getOrderIdByUser($userId)
    {

        $stmt = $this->pdo->prepare("SELECT id FROM orders WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetch();
    }
}
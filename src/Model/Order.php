<?php

class order
{
    public function createNewOrder($userId, $address, $phoneNumber)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, address, phoneNumber) 
            VALUES ($userId, $address, $phoneNumber)");
        $stmt->execute(['user_id' => $userId, 'address' => $address, 'phoneNumber' => $phoneNumber]);
    }
}
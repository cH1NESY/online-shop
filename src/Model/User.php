<?php

//namespace Model\Database;
require_once './../Model/Database.php';
class User
{
    private Database $pdo;
    public function __construct()
    {
        $this->pdo = new Database();
    }
    public function createNewUser(string $name,string $email,string $password)
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getByLogin(string $login):array
    {
        $connect = $this->pdo->connectToDatabase();
        $stmt = $connect->prepare("SELECT * FROM users WHERE email = :login");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();
        return $data;
    }
}
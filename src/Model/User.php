<?php

namespace Model;
//require_once './../Model/Database.php';
use Model\Database;
class User extends Database
{

    public function createNewUser(string $name,string $email,string $password)
    {

        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getByLogin(string $login):array
    {

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :login");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();
        return $data;
    }
}
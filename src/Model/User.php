<?php

namespace Model;
//require_once './../Model/Database.php';
use Model\Database;
class User extends Database
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function createNewUser(string $name,string $email,string $password)
    {

        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getByLogin(string $login):self|null
    {

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :login");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();
        if(empty($data))
        {
            return null;
        }

        return $this->hydrate($data);
    }


    private function hydrate(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];
        return $obj;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
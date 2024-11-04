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

    public static function createNewUser(string $name,string $email,string $password)
    {

        $stmt = self::getPDO()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public static function getByLogin(string $login):self|null
    {

        $stmt = self::getPDO()->prepare("SELECT * FROM users WHERE email = :login");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();
        if(empty($data))
        {
            return null;
        }

        return self::hydrate($data);
    }
    public static function getById(int $id):self|null
    {

        $stmt = self::getPDO()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        if(empty($data))
        {
            return null;
        }

        return self::hydrate($data);
    }


    private static function hydrate(array $data): self
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

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

}
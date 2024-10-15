<?php
//namespace Model;
class Database
{
    private $pdo;
    public function __construct(){
        $this->pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    }
    public function connectToDatabase()
    {
        return $this->pdo;
    }
}
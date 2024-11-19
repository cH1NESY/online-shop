<?php
namespace Model;
use pdo;
class Database
{
    protected static PDO $pdo;
    public static function getPDO(){
        if(!isset(self::$pdo)){
            self::$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        }
        return self::$pdo;
    }

}
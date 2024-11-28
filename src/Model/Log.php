<?php

namespace Model;

use Ch1nesy\MyCore\Database;


class Log extends Database
{
    public static function Createlog(string $message, string $file, string $line){
        $stmt = self::getPDO()->prepare("INSERT INTO logs (message, file, line) VALUES (:message, :file, :line)");
        $stmt->execute(['message' => $message, 'file' => $file, 'line' => $line]);

    }
}
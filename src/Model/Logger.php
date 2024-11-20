<?php

namespace Model;

class Logger extends Database
{
    public static function Createlog(string $message, string $file, string $line){
        $stmt = self::getPDO()->prepare("INSERT INTO log (message, file, line) VALUES (:message, :file, :line)");
        $stmt->execute(['message' => $message, 'file' => $file, 'line' => $line]);

    }
}
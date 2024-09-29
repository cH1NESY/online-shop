<?php

$name = $_GET['name'];
$email = $_GET['email'];
$pass = $_GET['password'];


$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')");

$res = $pdo->query( "SELECT * FROM users ORDER BY id DESC LIMIT 1");

print_r($res->fetch());
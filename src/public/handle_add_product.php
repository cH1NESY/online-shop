<?php
session_start();

function validate()
{
    $errors = [];

    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

    } else {
        $errors['product_id'] = "Поле product_id должно быть заполнено";
    }

    if (isset($_POST['amount'])) {
        $amount = $_POST['amount'];
    }


    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT id FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll();
    $product_id = $_POST['product_id'];
    $flag = true;

    foreach ($products as $product) {
        $id = $product['id'];
        //print_r($id);
        //echo "\n";
        //print_r($product_id);
        //echo "\n";
        if($product_id == $id) {
            $flag = false;
            print_r($flag);
            break;
        }

    }
    if($flag) {
        $errors['product_id'] = "Нет такого id";
    }
    return $errors;
}
$productId = $_POST['product_id'];
$userId = $_SESSION['user_id'];
$pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", "user", "pass");
$stmt=$pdo->prepare('SELECT * FROM user_products WHERE user_id = :user AND product_id = :product');
$stmt->execute(['user'=>$userId, 'product'=>$productId]);
$res = $stmt->fetch();
$amount = $res['amount'];

function addProduct()
{
    $amount= $_POST['amount'];

    $amount += $_POST['amount'];
    $productId = $_POST['product_id'];
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
}


function addRepeatProduct($amount)
{
    $errors = validate();
    if(empty($errors)) {
        $amount += $_POST['amount'];


        $productId = $_POST['product_id'];
        $userId = $_SESSION['user_id'];
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }
}
if($res === false){
    addProduct();
}else{
    addRepeatProduct($amount);
}
header('Location: /basket');




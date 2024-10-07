<?php
session_start();
$userId = $_SESSION['user_id'];
function validate()
{
    $errors = [];

    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

    } else {
        $errors['product_id'] = "Поле product_id должно быть заполнено";
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT id FROM products WHERE id = :product_id;");
        $stmt->execute();
        $products = $stmt->fetchAll();
        if($products === false){
            $errors['product_id'] = "Нет такого id";
        }
    }

    if (isset($_POST['amount'])) {
        $amount = $_POST['amount'];
    }

    return $errors;

}


$amount = $_POST['amount'];
$productId = $_POST['product_id'];
$pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", "user", "pass");
$stmt=$pdo->prepare('SELECT * FROM user_products WHERE user_id = :user AND product_id = :product');
$stmt->execute(['user'=>$userId, 'product'=>$productId]);
$res = $stmt->fetch();


function addProduct($productId, $amount, $userId)
{
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
}


function addRepeatProduct($productId ,$amount, $userId)
{
    $errors = validate();
    if(empty($errors)) {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }
}
if($res === false){
    addProduct($productId, $amount, $userId);
}else{
    $amount += $res['amount'];
    addRepeatProduct($productId ,$amount, $userId);
}
header('Location: /basket');




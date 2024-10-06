<?php
$flag = false;

function validate()
{
    $errors = [];

    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

    } else {
        $errors['product_id'] = "Поле name должно быть заполнено";
    }

    if (isset($_POST['amount'])) {
        $amount = $_POST['amount'];


    } else {
        $errors['email'] = "Поле email должно быть заполнено";
    }


}

$errors = validate();

if(empty($errors)) {
    $product_id = $_POST['product_id'];
    $amount= $_POST['amount'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    session_start();
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");


    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);

    header('Location: /basket');

}




require_once './get_add_product.php';
<?php
session_start();
$userId = $_SESSION['user_id'];
function validate()
{
    $errors = [];

    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare('SELECT id FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $products = $stmt->fetch();

        if($products === false){
            $errors['product_id'] = "Нет такого id";

        }
    } else {
        $errors['product_id'] = "Поле product_id должно быть заполнено";

    }

    if (isset($_POST['amount'])) {
        $amount = $_POST['amount'];
    }
    else{
        $errors['amount'] = "Поле amount должно быть заполнено";
    }

    return $errors;

}
function addProduct($productId, $amount, $userId)
{
    $errors = validate();
    if (empty($errors)) {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }else{
        require_once "./get_add_product.php";
    }
}

function addRepeatProduct($productId ,$amount, $userId)
{
    $errors = validate();
    if(empty($errors)) {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }else{
        require_once "./get_add_product.php";
    }
}

$errors = validate();
if (empty($errors)) {
    $amount = $_POST['amount'];
    $productId = $_POST['product_id'];
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", "user", "pass");
    $stmt = $pdo->prepare('SELECT * FROM user_products WHERE user_id = :userId AND product_id = :productId');
    $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    $res = $stmt->fetch();
    if($res === false){
        addProduct($productId, $amount, $userId);
    }else{
        $amount += $res['amount'];
        addRepeatProduct($productId ,$amount, $userId);
    }
    header('Location: /basket');
}else{
    require_once "./get_add_product.php";
}






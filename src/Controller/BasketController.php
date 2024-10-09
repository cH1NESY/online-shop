<?php


class BasketController
{
    public function getAddProductForm()
    {
        require_once "./../View/addProduct.php";
    }
    private function addProduct($productId, $amount, $userId)
    {

        $errors = $this->validateProduct();
        if (empty($errors)) {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
            $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
        }else{
            require_once "./../View/addProduct.php";
        }
    }

    private function addRepeatProduct($productId ,$amount, $userId)
    {

        $errors = $this->validateProduct();
        if(empty($errors)) {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
        }else{
            require_once "./../View/addProduct.php";
        }
    }
    public function checkProduct()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        $errors = $this->validateProduct();
        if (empty($errors)) {
            $amount = $_POST['amount'];
            $productId = $_POST['product_id'];
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", "user", "pass");
            $stmt = $pdo->prepare('SELECT * FROM user_products WHERE user_id = :userId AND product_id = :productId');
            $stmt->execute(['userId' => $userId, 'productId' => $productId]);
            $res = $stmt->fetch();
            if($res === false){
                $this->addProduct($productId, $amount, $userId);
            }else{
                $amount += $res['amount'];
                $this->addRepeatProduct($productId ,$amount, $userId);
            }
            header('Location: /basket');
        }else{
            require_once "./../View/addProduct.php";
        }
    }

    private function validateProduct()
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
    public function showProductsInBasket()
    {
        session_start();
        $user_id = $_SESSION['user_id'];

        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }

        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');



        $res = [];

        $stmt = $pdo->prepare("SELECT * FROM user_products JOIN products ON user_products.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $res = $stmt->fetchAll();
        require_once "./../View/basket.php";
        return $res;

    }
}
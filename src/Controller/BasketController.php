<?php
session_start();

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
            require_once "./../Model/UserProducts.php";
            $userProducts = new UserProducts();
            $userProducts->add($userId, $productId, $amount);
        }else{
            require_once "./../View/addProduct.php";
        }
    }

    private function addRepeatProduct($productId ,$amount, $userId)
    {

        $errors = $this->validateProduct();
        if(empty($errors)) {
            require_once "./../Model/UserProducts.php";
            $userProducts = new UserProducts();
            $userProducts->addRepetition($userId, $productId, $amount);
        }else{
            require_once "./../View/addProduct.php";
        }
    }
    public function checkProduct()
    {

        $userId = $_SESSION['user_id'];
        $errors = $this->validateProduct();
        if (empty($errors)) {
            $amount = $_POST['amount'];
            $productId = $_POST['product_id'];
            require_once "./../Model/UserProducts.php";
            $userProducts = new UserProducts();
            $res = $userProducts->check($userId, $productId);
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

        require_once "./../Model/UserProducts.php";
        $userProducts = new UserProducts();
        $res = $userProducts->getProductsInBasket($user_id);
        require_once "./../View/basket.php";
        return $res;

    }
}
<?php

namespace Controller;
use Model\UserProduct;
class BasketController
{

    private UserProduct $userProduct;

    public function __construct( )
    {
        $this->userProduct = new UserProduct();
    }
    public function getAddProductForm()
    {
        require_once "./../View/addProduct.php";
    }

    public function addProduct()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        $errors = $this->validateProduct();
        if (empty($errors)) {
            $amount = $_POST['amount'];
            $productId = $_POST['product_id'];

            $res = $this->userProduct->getByUserIdAndByProductId($userId, $productId);
            if($res === false){

                $this->userProduct->addProductInBasket($userId, $productId, $amount);
            }else{
                $amount += $res['amount'];

                $this->userProduct->updateAmount($userId, $productId, $amount);
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
            $pdo = new database('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
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

        require_once "./../Model/UserProduct.php";

        $res = $this->userProduct->getProductsByUserId($user_id);
        require_once "./../View/basket.php";


    }
}
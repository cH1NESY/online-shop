<?php
require_once "./../Model/Order.php";
require_once "./../Model/UserProduct.php";
class OrderController
{
    private Order $order;
    private UserProduct $userProduct;

    public function __construct()
    {
        $this->order = new Order();
        $this->userProduct = new UserProduct();
    }

    public function showProductsInOrder()
    {
        session_start();
        $user_id = $_SESSION['user_id'];

        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }

        $res = $this->userProduct->getProductsByUserId($user_id);

        require_once "./../View/order.php";
    }

    public function createOrder(){
        session_start();
        $userId = $_SESSION['user_id'];

        $address = $_POST["address"];
        $phoneNumber = $_POST["phoneNumber"];
        $this->order->createNewOrder($userId, $address, $phoneNumber);
        header('Location: /order');

    }
}
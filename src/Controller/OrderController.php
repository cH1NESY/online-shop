<?php
namespace Controller;
use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
class OrderController
{
    private Order $order;
    private UserProduct $userProduct;
    private OrderProduct $orderProduct;

    public function __construct()
    {
        $this->order = new Order();
        $this->userProduct = new UserProduct();
        $this->orderProduct = new OrderProduct();
    }

    public function showProductsReadyToOrder()
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
        $errors = $this->validateOrder();
        if(empty($errors))
        {
            session_start();
            $userId = $_SESSION['user_id'];
            $name = $_POST['name'];
            $address = $_POST["address"];
            $phoneNumber = $_POST["phoneNumber"];
            //$resProd = $this->userProduct->getProductsByUserId($userId);
            //$allPrice = 0;
            //foreach ($resProd as $r){
            //    $totalPrice = $r["price"] * $r["amount"];
            //    $allPrice += $totalPrice;
            //}
            $this->order->createNewOrder($userId, $name, $phoneNumber, $address);

            $orderId = $this->order->getOrderIdByUser($userId);

            foreach ($this->userProduct->getProductsByUserId($userId) as $product){
                $this->orderProduct->addProductInOrder($orderId['id'], $product['id'], $product['amount'], $product['price']);
            }

            $this->userProduct->deleteProductByUserId($userId);
            header('Location: /order');
        }else{
            require_once "./../View/order.php";
        }
    }

    private function validateOrder(): array
    {
        $errors = [];

        if (isset($_POST['name'])) {
            $name = ($_POST['name']);
            if (strlen($name) < 3 || strlen($name) > 20) {
                $errors['firstName'] = "Имя должно содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $name)) {
                $errors['firstName'] = "Имя может содержать только буквы";
            }
        }else{
            $errors ['firstName'] = "Поле name должно быть заполнено";
        }



        if (isset($_POST['address'])) {
            $address = ($_POST['address']);
           if (strlen($address) < 3 || strlen($address) > 100) {
                $errors['address'] = "Адресс должен содержать не меньше 3 символов и не больше 100 символов";
           } elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9 ,.-]+$/u", $address)) {
                $errors['address'] = "Адресс может содержать только буквы и цифры";
           }
        }else {
            $errors ['address'] = "Поле address должно быть заполнено";
        }




        if (isset($_POST['phoneNumber'])) {
            $phone = ($_POST['phoneNumber']);
            if (!preg_match("/^[0-9]+$/u", $phone)) {
                $errors['phone'] = "Номер телефона может содержать только цифры";
            } elseif (strlen($phone) < 3 || strlen($phone) > 15) {
                $errors['phone'] = "Номер телефона должен содержать не меньше 3 символов и не больше 15 символов";
            }
        }else {
            $errors ['phone'] = "Поле phoneNumber должно быть заполнено";
        }



        return $errors;
    }
}
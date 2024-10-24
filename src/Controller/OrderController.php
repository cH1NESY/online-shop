<?php
namespace Controller;
use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
use Request\OrderRequest;

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

    public function createOrder(OrderRequest $request){
        $errors = $this->validateOrder();
        if(empty($errors))
        {
            session_start();
            $userId = $_SESSION['user_id'];
            $name = $request->getName();
            $address = $request->getAddress();
            $phoneNumber = $request->getPhone();
            $res = $this->userProduct->getProductsByUserId($userId);
//            $allPrice = 0;
//            foreach ($res as $r){
//                $totalPrice = $r["price"] * $r["amount"];
//                $allPrice += $totalPrice;
//            }
            $this->order->createNewOrder($userId, $name, $phoneNumber, $address);

            $orderId = $this->order->getOrderIdByUser($userId);

            foreach ($this->userProduct->getProductsByUserId($userId) as $product){
                $this->orderProduct->addProductInOrder($orderId->getId(), $product->getProduct()->getId(), $product->getAmount(), $product->getProduct()->getPrice());
            }

            $this->userProduct->deleteProductByUserId($userId);

            header('Location: /order');

        }else{
            require_once "./../View/order.php";
        }
    }


}
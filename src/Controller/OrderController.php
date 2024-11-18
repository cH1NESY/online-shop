<?php
namespace Controller;
use DTO\CreateOrderDTO;
use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
use Request\OrderRequest;
use Service\OrderService;

class OrderController
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();

    }

    public function showProductsReadyToOrder()
    {
        session_start();
        $user_id = $_SESSION['user_id'];

        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }

        $res = UserProduct::getProductsByUserId($user_id);

        require_once "./../View/order.php";
    }

    public function createOrder(OrderRequest $request){
        $errors = $request->validateOrder();
        if(empty($errors))
        {
            session_start();
            $userId = $_SESSION['user_id'];
            $name = $request->getName();
            $address = $request->getAddress();
            $phoneNumber = $request->getPhone();
            $res = UserProduct::getProductsByUserId($userId);
//            $allPrice = 0;
//            foreach ($res as $r){
//                $totalPrice = $r["price"] * $r["amount"];
//                $allPrice += $totalPrice;
//            }
//            $this->order->createNewOrder($userId, $name, $phoneNumber, $address);
//
//            $orderId = $this->order->getOrderIdByUser($userId);
//
//            foreach ($this->userProduct->getProductsByUserId($userId) as $product){
//                $this->orderProduct->addProductInOrder($orderId->getId(), $product->getProduct()->getId(), $product->getAmount(), $product->getProduct()->getPrice());
//            }
//
//            $this->userProduct->deleteProductByUserId($userId);
            $dto = new CreateOrderDTO($userId, $name, $phoneNumber, $address);
            $this->orderService->create($dto);
            header('Location: /order');

        }else{
            session_start();
            $userId = $_SESSION['user_id'];
            $res = UserProduct::getProductsByUserId($userId);
            require_once "./../View/order.php";
        }
    }


}
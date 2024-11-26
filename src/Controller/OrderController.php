<?php
namespace Controller;
use DTO\CreateOrderDTO;
use Model\OrderProduct;
use Model\UserProduct;
use Request\OrderRequest;
use Service\Auth\AuthServiceInterface;

use Service\OrderService;

class OrderController
{
    private OrderService $orderService;
    private AuthServiceInterface $authService;
    public function __construct( OrderService $orderService, AuthServiceInterface $authService)
    {
        $this->orderService = $orderService;
        $this->authService = $authService;
    }

    public function showProductsReadyToOrder()
    {

        $userId = $this->authService->getCurrentUser()->getId();

        if(!$this->authService->check()){
            header('Location: /login');
        }

        $res = UserProduct::getProductsByUserId($userId);

        require_once "./../View/order.php";
    }

    public function createOrder(OrderRequest $request){
        if(!$this->authService->check())
        {
            header('Location: /login');
        }

        $userId = $this->authService->getCurrentUser()->getId();

        //$errors = $request->validateOrder();
        $errors = [];


        if(empty($errors))
        {


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

            $userId = $this->authService->getCurrentUser()->getId();
            $res = UserProduct::getProductsByUserId($userId);
            require_once "./../View/order.php";
        }

    }

    public function showOrderHistory()
    {



        if(!$this->authService->check()){
            header('Location: /login');
        }
        $userId = $this->authService->getCurrentUser()->getId();
        $res = OrderProduct::getOrderAndProductsByUser($userId);

        require_once "./../View/orderHistory.php";
    }

}
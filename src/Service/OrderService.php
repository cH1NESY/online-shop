<?php

namespace Service;
use DTO\CreateOrderDTO;
use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
use Request\OrderRequest;



class OrderService
{
    private Order $order;
    private UserProduct $userProduct;
    private OrderProduct $orderProduct;

    public function __construct( Order $order, UserProduct $userProduct, OrderProduct $orderProduct)
    {
        $this->order = $order;
        $this->userProduct = $userProduct;
        $this->orderProduct = $orderProduct;
    }
    public function create(CreateOrderDTO $OrderDTO)
    {
        $this->order->createNewOrder($OrderDTO->getUserId(), $OrderDTO->getName(), $OrderDTO->getPhoneNumber(), $OrderDTO->getAddress());

        $orderId = $this->order->getOrderIdByUser($OrderDTO->getUserId());

        foreach ($this->userProduct->getProductsByUserId($OrderDTO->getUserId()) as $product){
            $this->orderProduct->addProductInOrder($orderId->getId(), $product->getProduct()->getId(), $product->getAmount(), $product->getProduct()->getPrice());
        }

        $this->userProduct->deleteProductByUserId($OrderDTO->getUserId());
    }
}
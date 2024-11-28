<?php

namespace Service;
use DTO\CreateOrderDTO;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;


class OrderService
{

    public function create(CreateOrderDTO $OrderDTO)
    {
        //Database::getPDO()->beginTransaction();
        //try {


            Order::createNewOrder($OrderDTO->getUserId(), $OrderDTO->getName(), $OrderDTO->getPhoneNumber(), $OrderDTO->getAddress());

            $orderId = Order::getOrderIdByUser($OrderDTO->getUserId());

            foreach (UserProduct::getProductsByUserId($OrderDTO->getUserId()) as $product) {
                OrderProduct::addProductInOrder($orderId->getId(), $product->getProduct()->getId(), $product->getAmount(), $product->getProduct()->getPrice());
            }

            UserProduct::deleteProductByUserId($OrderDTO->getUserId());
//        } catch (\PDOException $e) {
//            Database::getPDO()->rollBack();
//            echo $e->getMessage();
//            throw $e;
//
//        }
//        Database::getPDO()->commit();
    }
}
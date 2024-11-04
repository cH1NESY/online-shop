<?php
namespace Model;
//require_once './../Model/Database.php';
use Model\Database;
class OrderProduct extends Database
{
    private int $id;
    private Order $order;
    private Product $product;
    private int $amount;
    private int $price;
    public static function addProductInOrder(int $orderId, int $productId, int $amount, int $price)
    {
        $stmt = self::getPDO()->prepare("INSERT INTO order_products (orderId, productId, amount, price) 
            VALUES (:orderId, :productId, :amount, :price)");
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount, 'price' => $price]);

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrderProduct
     */
    public function setId(int $id): OrderProduct
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return OrderProduct
     */
    public function setOrder(Order $order): OrderProduct
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return OrderProduct
     */
    public function setPrice(int $price): OrderProduct
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return OrderProduct
     */
    public function setAmount(int $amount): OrderProduct
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return OrderProduct
     */
    public function setProduct(Product $product): OrderProduct
    {
        $this->product = $product;
        return $this;
    }

}
<?php
//require_once './../Model/Database.php';

namespace Model;
use Model\Database;
class Order extends Database
{
    private int $id;
    private int $userId;
    private string $contactName;
    private string $contactNumber;
    private string $address;
    private string $totalPrice;
    public function createNewOrder($userId, $contactName, $contactNumber, $address, $totalPrice)
    {

        $stmt = $this->pdo->prepare("INSERT INTO orders (userId, contactName, contactNumber, address, totalPrice) 
        VALUES (:userId, :contactName, :contactNumber, :address, :totalPrice)");
        $stmt->execute(['userId' => $userId, 'contactName' => $contactName, 'contactNumber' => $contactNumber, 'address' => $address, 'totalPrice' => $totalPrice]);
    }

    public function getOrderIdByUser($userId):self|null
    {
        $stmt = $this->pdo->prepare("SELECT id FROM orders WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $orderIds = $stmt->fetch();
        if (empty($orderIds)) {
            return null;
        }
        return $this->hydrate($orderIds);
    }

    private function hydrate(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['userId'];
        $obj->contactName = $data['contactName'];
        $obj->contactNumber = $data['contactNumber'];
        $obj->address = $data['address'];
        $obj->totalPrice = $data['totalPrice'];

        return $obj;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContactName(): string
    {
        return $this->contactName;
    }

    /**
     * @return string
     */
    public function getContactNumber(): string
    {
        return $this->contactNumber;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getTotalPrice(): string
    {
        return $this->totalPrice;
    }


}
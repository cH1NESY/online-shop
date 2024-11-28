<?php
//require_once './../Model/Database.php';

namespace Model;
use Ch1nesy\MyCore\Database;

class Order extends Database
{
    private int $id;
    private User $user;
    private string $contactName;
    private string $contactNumber;
    private string $address;
    private int $totalPrice;
    public static function createNewOrder(int $userId,string $contactName,string $contactNumber,string $address)
    {

        $stmt = self::getPDO()->prepare("INSERT INTO orders (userId, contactName, contactNumber, address) 
        VALUES (:userId, :contactName, :contactNumber, :address)");
        $stmt->execute(['userId' => $userId, 'contactName' => $contactName, 'contactNumber' => $contactNumber, 'address' => $address]);
    }

    public static function getOrderIdByUser($userId):self|null
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM orders WHERE userId = :userId ORDER BY id DESC");
        $stmt->execute(['userId' => $userId]);
        $orderIds = $stmt->fetch();
        if (empty($orderIds)) {
            return null;
        }

        return self::hydrate($orderIds);
    }



    private static function hydrate(array $data): self
    {
        $user = new User();
        $userFromDb = $user->getById($data['userid']);

        $obj = new self();
        $obj->id = $data['id'];
        $obj->user = $userFromDb;
        $obj->contactName = $data['contactname'];
        $obj->contactNumber = $data['contactnumber'];
        $obj->address = $data['address'];
        //$obj->totalPrice = $data['totalPrice'];

        return $obj;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
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

    /**
     * @param int $id
     * @return Order
     */
    public function setId(int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $totalPrice
     * @return Order
     */
    public function setTotalPrice(string $totalPrice): Order
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    /**
     * @param string $address
     * @return Order
     */
    public function setAddress(string $address): Order
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param string $contactNumber
     * @return Order
     */
    public function setContactNumber(string $contactNumber): Order
    {
        $this->contactNumber = $contactNumber;
        return $this;
    }

    /**
     * @param string $contactName
     * @return Order
     */
    public function setContactName(string $contactName): Order
    {
        $this->contactName = $contactName;
        return $this;
    }

    /**
     * @param User $user
     * @return Order
     */
    public function setUser(User $user): Order
    {
        $this->user = $user;
        return $this;
    }



}
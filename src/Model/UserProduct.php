<?php
namespace Model;
//require_once './../Model/Database.php';

use Model\Database;
use Model\Product;
class UserProduct extends Database
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }
    public function getByUserIdAndByProductId(int $userId, int $productId):self|null
    {

        $stmt = $this->pdo->prepare('SELECT * FROM user_products WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();

        if(empty($res))
        {
            return null;
        }
        return $this->hydrate($res);
    }

    public function addProductInBasket(int $userId,int $productId,int $amount)
    {

        $stmt = $this->pdo->prepare("INSERT INTO user_products (userId, productId, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateAmount(int $userId,int $productId,int $amount)
    {

        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE userId = :userId AND productId = :productId");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function getProductsByUserId(int $userId): array|null
    {

        $stmt = $this->pdo->prepare("SELECT * FROM user_products JOIN products ON user_products.productId = products.id WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $res = $stmt->fetchAll();

        if(empty($res))
        {
            return null;
        }
        foreach ($res as &$product)
        {
            $product = $this->hydrate($product);
        }

        return $res;
    }

    public function deleteProductByUserId(int $userId)
    {

        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);

    }

    private function hydrate(array $data):self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['userid'];
        $obj->productId = $data['productid'];
        $obj->amount = $data['amount'];

        return $obj;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getImage()
    {
        return $this->product->getImage();
    }

}
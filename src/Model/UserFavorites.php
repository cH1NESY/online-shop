<?php

namespace Model;
use Model\Database;
class UserFavorites extends Database
{
    private int $id;
    private int $userId;
    private int $productId;
    public function getByUserIdAndByProductId(int $userId, int $productId):self|null
    {

        $stmt = $this->pdo->prepare('SELECT * FROM user_favorites WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();
        if(empty($res))
        {
            return null;
        }
        return $this->hydrate($res);
    }

    public function addProductInFavorite(int $userId, int $productId){

        $stmt = $this->pdo->prepare('INSERT INTO user_favorites (userId, productId) VALUES (:userId, :productId)');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public function deleteProduct(int $userId, int $productId){

        $stmt = $this->pdo->prepare('DELETE FROM user_favorites WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }
    public function getProductsByUserId(int $userId): array|null
    {

        $stmt = $this->pdo->prepare("SELECT * FROM user_favorites WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $products = $stmt->fetchAll();
        if(empty($products))
        {
            return null;
        }
        foreach ($products as &$product)
        {
            $product = $this->hydrate($product);
        }
        return $products;
    }

    private function hydrate(array $data):self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['userId'];
        $obj->productId = $data['productId'];

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

}
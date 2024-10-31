<?php

namespace Model;
use Model\Database;

class UserFavorites extends Database
{
    private int $id;
    private User $user;
    private Product $product;
    public static function getByUserIdAndByProductId(int $userId, int $productId):self|null
    {

        $stmt = self::$pdo->prepare('SELECT * FROM user_favorites WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();

        if(empty($res))
        {
            return null;
        }
        return self::hydrate($res);
    }

    public static function addProductInFavorite(int $userId, int $productId){

        $stmt = self::$pdo->prepare('INSERT INTO user_favorites (userId, productId) VALUES (:userId, :productId)');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public static function deleteProduct(int $userId, int $productId){

        $stmt = self::$pdo->prepare('DELETE FROM user_favorites WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
    }
    public static function getProductsByUserId(int $userId): array|null
    {

        $stmt = self::$pdo->prepare("SELECT * FROM user_favorites WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $products = $stmt->fetchAll();

        if(empty($products))
        {
            return null;
        }

        foreach ($products as &$product)
        {
            $product = self::hydrate($product);

        }

        return $products;
    }


    private static function hydrate(array $data):self
    {

        $user = new User();
        $userFromDb = $user->getById($data['userid']);

        $product = new Product();
        $productFromDb = $product->getProductIdsByProductId($data['productid']);

        $obj = new self();
        $obj->id = $data['id'];
        $obj->user= $userFromDb;
        $obj->product = $productFromDb;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }






    /**
     * @param int $id
     * @return UserFavorites
     */
    public function setId(int $id): UserFavorites
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param Product $product
     * @return UserFavorites
     */
    public function setProduct(Product $product): UserFavorites
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @param User $user
     * @return UserFavorites
     */
    public function setUser(User $user): UserFavorites
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param int $productId
     * @return UserFavorites
     */


}
<?php
namespace Model;
//require_once './../Model/Database.php';

use Ch1nesy\MyCore\Database;

class UserProduct extends Database
{
    private int $id;
    private User $user;
    private Product $product;
    private int $amount;



    public static function getByUserIdAndByProductId(int $userId, int $productId):self|null
    {

        $stmt = self::getPDO()->prepare('SELECT * FROM user_products WHERE userId = :userId AND productId = :productId');
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $res = $stmt->fetch();

        if(empty($res))
        {
            return null;
        }
        return self::hydrate($res);
    }

    public static function addProductInBasket(int $userId,int $productId,int $amount)
    {

        $stmt = self::getPDO()->prepare("INSERT INTO user_products (userId, productId, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public static function updateAmount(int $userId,int $productId,int $amount)
    {

        $stmt = self::getPDO()->prepare("UPDATE user_products SET amount = :amount WHERE userId = :userId AND productId = :productId");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public static function getProductsByUserId(int $userId): array|null
    {

        $stmt = self::getPDO()->prepare("SELECT * FROM user_products 
                                            JOIN products ON products.id = user_products.productId 
                                            JOIN users ON users.id = user_products.userId
                                            WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);
        $res = $stmt->fetchAll();

        if(empty($res))
        {
            return null;
        }
        foreach ($res as &$product)
        {
            $product = self::hydrate($product);
        }

        return $res;
    }

    public static function deleteProductByUserId(int $userId)
    {

        $stmt = self::getPDO()->prepare("DELETE FROM user_products WHERE userId = :userId");
        $stmt->execute(['userId' => $userId]);

    }

    private static function hydrate(array $data):self
    {
        $user = new User();
        $user->setId($data['userid']);
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        $product = new Product();
        $product->setId($data['productid']);
        $product->setTitle($data['title']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);
        $product->setImage($data['image']);

        $obj = new self();
        $obj->id = $data['id'];
        $obj->user = $user;
        $obj->product = $product;
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
     * @return UserProduct
     */
    public function setId(int $id): UserProduct
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param int $amount
     * @return UserProduct
     */
    public function setAmount(int $amount): UserProduct
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param Product $product
     * @return UserProduct
     */
    public function setProduct(Product $product): UserProduct
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @param User $user
     * @return UserProduct
     */
    public function setUser(User $user): UserProduct
    {
        $this->user = $user;
        return $this;
    }







}
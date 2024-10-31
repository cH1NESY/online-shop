<?php
namespace Model;
//require_once './../Model/Database.php';
use Model\Database;
class Product extends Database
{
    private int $id;
    private string $title;
    private string $description;
    private int $price;
    private string $image;

    public static function getProducts(): array|null
    {

        $stmt = self::$pdo->prepare("SELECT *  FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        if(empty($products)){
            return null;
        }
        foreach ($products as &$product) {
            $product = self::hydrate($product);
        }

        return $products;
    }

    public static function getProductIdsByProductId(int $productId): self |null
    {

        $stmt = self::$pdo->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $products = $stmt->fetch();
        if(empty($products)){
            return null;
        }
        return self::hydrate($products);
    }
    public static function getProductsByProductId(int $productId): self|null
    {

        $stmt = self::$pdo->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $products = $stmt->fetch();
        if(empty($products)){
            return null;
        }
        return self::hydrate($products);
    }

    private static function hydrate(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->title = $data['title'];
        $obj->description = $data['description'];
        $obj->price = $data['price'];
        $obj->image = $data['image'];

        return $obj;
    }


    public function getImage(): string
    {
        return $this->image;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function getPrice(): int
    {
        return $this->price;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $image
     * @return Product
     */
    public function setImage(string $image): Product
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param string $title
     * @return Product
     */
    public function setTitle(string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param int $price
     * @return Product
     */
    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }
}
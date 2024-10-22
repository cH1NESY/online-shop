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

    public function getProducts(): array|null
    {

        $stmt = $this->pdo->prepare("SELECT *  FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll();
        if(empty($products)){
            return null;
        }
        foreach ($products as &$product) {
            $product = $this->hydrate($product);
        }

        return $products;
    }

    public function getProductIdsByProductId(int $productId): self |null
    {

        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $products = $stmt->fetch();
        if(empty($products)){
            return null;
        }
        return $this->hydrate($products);
    }
    public function getProductsByProductId(int $productId): self|null
    {

        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->execute(['productId' => $productId]);
        $products = $stmt->fetch();
        if(empty($products)){
            return null;
        }
        return $this->hydrate($products);
    }

    private function hydrate(array $data): self
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
}
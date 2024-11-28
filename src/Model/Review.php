<?php

namespace Model;

use Ch1nesy\MyCore\Database;

class Review extends Database
{
    private int $id;
    private Product $product;
    private User $user;
    private string $text;
    private float $rating;
    private string $date;

    public static function addReview(int $productId, int $userId, string $text, float $rating, string $date)
    {
        $stmt = self::getPDO()->prepare("INSERT INTO reviews (productId, userId, text, rating, date) 
        VALUES (:productId, :userId, :text, :rating, :date)");
        $stmt->execute(['productId' => $productId, 'userId' => $userId,'text' => $text, 'rating' => $rating, 'date' => $date]);

    }


    public static function getByProductId($productId):array|null
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM reviews WHERE productId = :productId ");
        $stmt->execute(['productId' => $productId]);
        $reviews = $stmt->fetchAll();

        if (empty($reviews)) {
            return null;
        }
        $res = [];
        foreach ($reviews as $review) {
            $res[] = self::hydrate($review);
        }
        return $res;
    }

    public static function getByUserId($userId):array|null
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM reviews WHERE userId = :userId ");
        $stmt->execute(['userId' => $userId]);
        $reviews = $stmt->fetchAll();
        if (empty($reviewIds)) {
            return null;
        }

        $res = [];
        foreach ($reviews as $review) {
            $res[] = self::hydrate($review);
        }
        return $res;
    }

    private static function hydrate(array $data): self
    {
        $product = new Product();
        $user = new User();
        $productFromDb = $product->getProductsByProductId($data['productid']);
        $userFromDb = $user->getById($data['userid']);

        $obj = new self();
        $obj->id = $data['id'];
        $obj->product = $productFromDb;
        $obj->user = $userFromDb;
        $obj->text = $data['text'];
        $obj->rating = $data['rating'];
        $obj->date = $data['date'];


        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Review
    {
        $this->id = $id;
        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): Review
    {
        $this->date = $date;
        return $this;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating): Review
    {
        $this->rating = $rating;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): Review
    {
        $this->text = $text;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Review
    {
        $this->user = $user;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): Review
    {
        $this->product = $product;
        return $this;
    }


}
<?php

namespace Controller;
use Model\UserFavorites;
use Model\Product;
use Request\AddProductRequest;

class FavoriteController
{
    private UserFavorites $userFavorites;
    private Product $product;

    public function __construct( )
    {
        $this->userFavorites = new UserFavorites();
        $this->product = new Product();
    }
    public function addProduct(AddProductRequest $request)
    {
        session_start();
        $userId = $_SESSION['user_id'];

            $productId = $request->getProductId();

            $res = $this->userFavorites->getByUserIdAndByProductId($userId, $productId);

            if(empty($res)){
                $this->userFavorites->addProductInFavorite($userId, $productId);
            }else{
                $this->userFavorites->deleteProduct($userId, $productId);
            }

            header('Location: /favorite');


    }

    public function deleteProduct()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'];
        $this->userFavorites->deleteProduct($userId, $productId);
        header('Location: /catalog');
    }

    public function showProductsInFavorite()
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }
        $products = [];
        $productsInFavorite = $this->userFavorites->getProductsByUserId($user_id);

        foreach($productsInFavorite as $productInFavorite){
            $product = $this->product->getProductsByProductId($productInFavorite->getProduct()->getId());
            $products[] = $product;
        }


        require_once "./../View/favorite.php";


    }

}
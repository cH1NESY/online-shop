<?php

namespace Controller;
use Model\UserProduct;
use Model\Product;
use Request\AddProductInBasketRequest;
use DTO\AddProductDTO;
use Service\AuthService;
use Service\BasketService;

class BasketController
{

   private BasketService $basketService;
    private UserProduct $userProduct;
    private AuthService $authService;
    public function __construct( )
    {
        $this->basketService = new BasketService();
        $this->userProduct = new UserProduct();
        $this->authService = new AuthService();
    }
    public function getAddProductForm()
    {
        require_once "./../View/addProduct.php";
    }

    public function addProduct(AddProductInBasketRequest $request)
    {

        $userId =  $this->authService->getCurrentUser()->getId();
        $errors = $request->validateProduct();
        if (empty($errors)) {
            $amount = $request->getAmount();
            $productId = $request->getProductId();

            $dto = new addProductDTO($userId, $productId, $amount);
            $this->basketService->addProduct($dto);
            header('Location: /basket');
        }else{
            require_once "./../View/addProduct.php";
        }
    }


    public function showProductsInBasket()
    {

        $user_id =  $this->authService->getCurrentUser()->getId();

        if(!isset($_SESSION['user_id'])){
            header('Location: /login');
        }

        require_once "./../Model/UserProduct.php";

        $res = $this->userProduct->getProductsByUserId($user_id);


        require_once "./../View/basket.php";


    }
}
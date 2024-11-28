<?php

namespace Controller;
use Ch1nesy\MyCore\AuthServiceInterface;
use DTO\AddProductDTO;
use Model\UserProduct;
use Request\AddProductInBasketRequest;
use Service\BasketService;

class BasketController
{

   private BasketService $basketService;
    private UserProduct $userProduct;
    private AuthServiceInterface $authService;
    public function __construct( BasketService $basketService, UserProduct $userProduct, AuthServiceInterface $authService )
    {
        $this->basketService = $basketService;
        $this->userProduct = $userProduct;
        $this->authService = $authService;
    }
    public function getAddProductForm()
    {
        if(!$this->authService->check())
        {
            header('Location: /login');
        }else{
            require_once "./../View/addProduct.php";
        }

    }

    public function addProduct(AddProductInBasketRequest $request)
    {
        if(!$this->authService->check())
        {
            header('Location: /login');
        }else{


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

}


    public function showProductsInBasket()
    {



        if($this->authService->check()){
            $user_id =  $this->authService->getCurrentUser()->getId();
            require_once "./../Model/UserProduct.php";

            $res = $this->userProduct->getProductsByUserId($user_id);


            require_once "./../View/basket.php";

        }else{
            header('Location: /login');
        }



    }
}
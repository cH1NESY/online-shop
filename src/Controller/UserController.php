<?php

namespace Controller;
use Model\User;
use Request\RegistrateRequest;
use Request\LoginRequest;
use Service\AuthService;

class UserController
{
    private User $user;
    private AuthService $authService;
    public function __construct()
    {
        $this->user = new User();
        $this->authService = new AuthService();
    }
    public function getRegistrateForm()
    {
        require_once "./../View/registrate.php";
    }
    public function registrate(RegistrateRequest $request)
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $pass = $request->getPassword();
            $repass = $request->getRepassword();


            $hash = password_hash($pass, PASSWORD_DEFAULT);


            $this->user->createNewUser($name, $email, $hash);
            header('Location: /login');
        }

        require_once "./../View/registrate.php";


    }



    public function login(LoginRequest $request)
    {

        $errors = $request->validate();

        if(empty($errors)) {

            $login = $request->getLogin();
            $pass = $request->getPassword();
            if($this->authService->login($login, $pass))
            {
                header('Location: /catalog');
            }else
            {
                $errors['login'] = "Пароль или Логин неверный";
            }

//            $data = $this->user->getByLogin($login);
//
//
//            if(empty($data)){
//                $errors['login'] = "Пароль или Логин неверный";
//
//            }else{
//                $pass_db = $data->getPassword() ;
//
//                if(password_verify($pass, $pass_db)) {
//
//                    session_start();
//                    $_SESSION['user_id'] = $data->getId();
//                    header('Location: /catalog');
//                }
//                else{
//                    $errors['login'] = "Пароль или Логин неверный";
//
//                }
//            }

        }
        require_once "./../View/registrate.php";

    }



}
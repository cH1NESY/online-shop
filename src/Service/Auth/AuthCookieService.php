<?php

namespace Service\Auth;

use Ch1nesy\MyCore\AuthServiceInterface;
use Model\User;

class AuthCookieService implements AuthServiceInterface
{
    public function __construct()
    {
        $this->user = new User();
    }
    public function check():bool
    {
        $this->sessionStart();
        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if(!$this->check())
        {
            return NULL;
        }
        $this->sessionStart();
        $userId = $_COOKIE['user_id'];

        return User::getByID($userId);
    }

    private function sessionStart()
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
    }

    public function login(string $login, string $password): bool
    {


        $data = $this->user->getByLogin($login);


        if(empty($data)){
            $errors['login'] = "Пароль или Логин неверный";

        }else{
            $passDb = $data->getPassword() ;

            if(password_verify($password, $passDb))
            {
                $this->sessionStart();
                $_COOKIE['user_id'] = $data->getId();
                return true;
            }
            return false;
        }
        return false;
    }
}
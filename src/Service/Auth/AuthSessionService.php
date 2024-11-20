<?php

namespace Service\Auth;
use Model\User;

class AuthSessionService implements AuthServiceInterface
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function check():bool
    {
           $this->sessionStart();
           return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if(!$this->check())
        {
            return NULL;
        }
        $this->sessionStart();
        $userId = $_SESSION['user_id'];

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
                $_SESSION['user_id'] = $data->getId();
                return true;
            }
            return false;
        }
        return false;
    }
}
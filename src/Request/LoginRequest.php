<?php

namespace Request;

class LoginRequest extends Request
{

    public function getLogin():?string
    {
        return $this->data['login'] ?? null;
    }
    public function getPassword():?string
    {
        return $this->data['password'] ?? null;
    }
    public function validate()
    {
        $errors = [];

        if(!isset($this->data['login'])){
            $errors['login'] = "Поле email должно быть заполнено";
        }



        if(!isset($this->data['password'])) {
            $errors['password'] = "Поле password должно быть заполнено";
        }

        return $errors;
    }

}
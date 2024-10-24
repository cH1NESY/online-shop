<?php

namespace Request;

class OrderRequest extends Request
{
    public function getName():?string
    {
        return $this->data['name'] ?? null;
    }
    public function getAddress():?string
    {
        return $this->data['address'] ?? null;
    }
    public function getPhone():?string
    {
        return $this->data['phoneNumber'] ?? null;
    }


    private function validateOrder(): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = ($data['name']);
            if (strlen($name) < 3 || strlen($name) > 20) {
                $errors['firstName'] = "Имя должно содержать не меньше 3 символов и не больше 20 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $name)) {
                $errors['firstName'] = "Имя может содержать только буквы";
            }
        }else{
            $errors ['firstName'] = "Поле name должно быть заполнено";
        }



        if (isset($data['address'])) {
            $address = ($data['address']);
            if (strlen($address) < 3 || strlen($address) > 100) {
                $errors['address'] = "Адресс должен содержать не меньше 3 символов и не больше 100 символов";
            } elseif (!preg_match("/^[a-zA-Zа-яА-Я0-9 ,.-]+$/u", $address)) {
                $errors['address'] = "Адресс может содержать только буквы и цифры";
            }
        }else {
            $errors ['address'] = "Поле address должно быть заполнено";
        }




        if (isset($data['phoneNumber'])) {
            $phone = ($data['phoneNumber']);
            if (!preg_match("/^[0-9]+$/u", $phone)) {
                $errors['phone'] = "Номер телефона может содержать только цифры";
            } elseif (strlen($phone) < 3 || strlen($phone) > 15) {
                $errors['phone'] = "Номер телефона должен содержать не меньше 3 символов и не больше 15 символов";
            }
        }else {
            $errors ['phone'] = "Поле phoneNumber должно быть заполнено";
        }



        return $errors;
    }
}
<?php

namespace Request;


use Ch1nesy\MyCore\Request;
class RegistrateRequest extends Request
{
    public function getName():?string
    {
        return $this->data['name'] ?? null;
    }
    public function getEmail():?string
    {
        return $this->data['email'] ?? null;
    }
    public function getPassword():?string
    {
        return $this->data['password'] ?? null;
    }
    public function getRePassword():?string
    {
        return $this->data['repassword'] ?? null;
    }


    public function validate()
    {
        $errors = [];



        if(isset($this->data['name']) ){

            $name = $this->data['name'];


            if (empty($name)) {
                $errors['name'] = "Имя не может быть пустым";

            }
            if($name < 1){

                $errors['name'] = "Имя должно быть длиннее";

            }
            for($i = 0; $i < strlen($name); $i++){
                if (is_numeric($name[$i])) {

                    $errors['name'] = "В имени не должно быть цифр";

                }
                if ($name[$i] == " ") {

                    $errors['name'] = "В имени не должно быть пробелов";
                }
            }
            if(!preg_match("#^[\w\-]+$#u",$name)){

                $errors['name'] = "В имени не должно быть специальных символов";
            }
        }
        else{
            $errors['name'] = "Поле name должно быть заполнено";
        }




        if(isset($this->data['email'])){
            $email = $this->data['email'];
            $true_email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if(!$true_email){

                $errors['email'] = "Неправильный email";

            }
        }
        else{
            $errors['email'] = "Поле email должно быть заполнено";
        }





        if(isset($this->data['password'])){
            $pass = $this->data['password'];
            if (empty($pass)) {

                $errors['password'] = "Пароль не может быть пустым";

            }
        }
        else{
            $errors['password'] = "Поле password должно быть заполнено";
        }



        if (isset($this->data['repassword'])){
            $repass = $this->data['repassword'];
            $pass = $this->data['password'];
            if ($pass != $repass) {

                $errors['repassword'] = "Проверьте пароль";

            }
            if (empty( $repass)) {

                $errors['repassword'] = "Проверьте пароль";
            }
        }
        else{
            $errors['repassword'] = "Повторите пароль";
        }

        return $errors;
    }
}
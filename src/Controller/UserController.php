<?php

//namespace Controller;
//use Model\User;
class UserController
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function getRegistrateForm()
    {
        require_once "./../View/registrate.php";
    }
    public function registrate()
    {
        $errors = $this->validateRegistration();
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $repass = $_POST['repassword'];


            $hash = password_hash($pass, PASSWORD_DEFAULT);


            $this->user->createNewUser($name, $email, $hash);
            header('Location: /login');
        }

        require_once "./../View/registrate.php";


    }

    private function validateRegistration()
    {
        $errors = [];



        if(isset($_POST['name']) ){

            $name = $_POST['name'];


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




        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $true_email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if(!$true_email){

                $errors['email'] = "Неправильный email";

            }
        }
        else{
            $errors['email'] = "Поле email должно быть заполнено";
        }





        if(isset($_POST['password'])){
            $pass = $_POST['password'];
            if (empty($pass)) {

                $errors['password'] = "Пароль не может быть пустым";

            }
        }
        else{
            $errors['password'] = "Поле password должно быть заполнено";
        }



        if (isset($_POST['repassword'])){
            $repass = $_POST['repassword'];
            $pass = $_POST['password'];
            if ($pass != $repass) {

                $errors['repass'] = "Проверьте пароль";

            }
            if (empty( $repass)) {

                $errors['repass'] = "Проверьте пароль";
            }
        }
        else{
            $errors['repass'] = "Повторите пароль";
        }

        return $errors;
    }

    public function login(){

        $errors = $this->validateLogin();

        if(empty($errors)) {

            $login = $_POST['login'];
            $pass = $_POST['password'];

            $data = $this->user->getByLogin($login);


            if($data === false){
                $errors['login'] = "Пароль или Логин неверный";

            }else{
                $pass_db = $data['password'] ;

                if(password_verify($pass, $pass_db)) {

                    session_start();
                    $_SESSION['user_id'] = $data['id'];
                    header('Location: /catalog');
                }
                else{
                    $errors['login'] = "Пароль или Логин неверный";

                }
            }

        }
        require_once "./../View/registrate.php";

    }

    private function validateLogin()
    {
        $errors = [];

        if(isset($_POST['login'])){
            $login = $_POST['login'];
        }
        else{
            $errors['login'] = "Поле email должно быть заполнено";
        }


        if(isset($_POST['password'])){
            $pass = $_POST['password'];
        }
        else{
            $errors['password'] = "Поле password должно быть заполнено";
        }

        return $errors;
    }

}
<?php
$flag = false;

function validate()
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


$errors = validate();

if(empty($log_errors)) {

    $login = $_POST['login'];
    $pass = $_POST['password'];


    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');


    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :login");
    $stmt->execute(['login' => $login]);
    $data = $stmt->fetch();


    if($data === false){
        $errors['login'] = "Пароль или Логин неверный";

    }else{
        $pass_db = $data['password'] ;

        if(password_verify($pass, $pass_db)) {
            setcookie('user_id', $data['id']);
            header('Location: /catalog.php');
            echo " ";
        }
        else{
            $errors['login'] = "Пароль или Логин неверный";
        }
    }




    //$stmt->execute(['email' => $true_email]);

    //print_r($stmt->fetch());
}


require_once './get_registration.php';
?>






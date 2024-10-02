<?php
$flag = false;

function validate()
{
    $errors = [];

    if(isset($_POST['name']) ){

        $name = $_POST['name'];


        if (empty($name)) {
            $errors['name'] = "Имя не может быть пустым";

        }
        if($name < 1){
            $flag = true;
            $errors['name'] = "Имя должно быть длиннее";

        }
        for($i = 0; $i < strlen($name); $i++){
            if (is_numeric($name[$i])) {
                $flag = true;
                $errors['name'] = "В имени не должно быть цифр";

            }
            if ($name[$i] == " ") {
                $flag = true;
                $errors['name'] = "В имени не должно быть пробелов";
            }
        }
        if(!preg_match("#^[\w\-]+$#u",$name)){
            $flag = true;
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
            $flag = true;
            $errors['email'] = "Неправильный email";

        }
    }
    else{
        $errors['email'] = "Поле email должно быть заполнено";
    }





    if(isset($_POST['password'])){
        $pass = $_POST['password'];
        if (empty($pass)) {
            $flag = true;
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
            $flag = true;
            $errors['repass'] = "Проверьте пароль";

        }
        if (empty( $repass)) {
            $flag = true;
            $errors['repass'] = "Проверьте пароль";
        }
    }
    else{
        $errors['repass'] = "Повторите пароль";
    }
    return $errors;
}


$errors = validate();

if(empty($errors)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $repass = $_POST['repassword'];
    $true_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    $hash = password_hash($pass, PASSWORD_DEFAULT);


    $stmt->execute(['name' => $name, 'email' => $true_email, 'password' => $hash]);


    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $true_email]);

    //print_r($stmt->fetch());
}


require_once './get_registration.php';
?>





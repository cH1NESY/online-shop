<?php
$flag = false;

$name = $_POST['name'];
$email = $_POST['email'];
$true_email = filter_var($email, FILTER_VALIDATE_EMAIL);
$pass = $_POST['password'];
$repass = $_POST['repassword'];

    if (empty($name)) {
        $flag = true;
        echo "Имя не может быть пустым";
    }
    if($name < 1){
        $flag = true;
        echo "Имя должно быть длиннее";
    }
    for($i = 0; $i < strlen($name); $i++){
        if (is_numeric($name[$i])) {
            $flag = true;
            echo "Проверьте правильность имени";
        }
        if ($name[$i] == " ") {
            $flag = true;
            echo "Проверьте правильность имени";
        }
    }
    if(!preg_match("#^[\w\-]+$#u",$name)){
        $flag = true;
        echo "Проверьте правильность имени";
    }

    if(!$true_email){
        $flag = true;
        echo "Неправильный email" ;
    }

    if (empty($pass)) {
        $flag = true;
        echo "Пароль не может быть пустым";
    }


    if ($pass != $repass) {
        $flag = true;
        echo "Проверьте пароль";
    }
    if (empty( $repass)) {
        $flag = true;
        echo "Проверьте пароль";
    }




if($flag == false){


    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    $hash = password_hash($pass, PASSWORD_DEFAULT);


    $stmt->execute(['name' => $name, 'email' => $true_email, 'password' => $hash]);


    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $true_email]);

    print_r($stmt->fetch());
}
<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/components/components.php');

if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {  
    displayError('Неверный логин или пароль');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {   
    displayError('Email адрес указан неверно');
}

$sql = 'SELECT * FROM user WHERE email = :email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);
$user = $statement->fetch(PDO::FETCH_OBJ);

if (!$user || !password_verify($password, $user->password)) {
    displayError('Неверный логин или пароль');
}

$_SESSION['user_id'] = $user->id;
$_SESSION['user_email'] = $user->email;

if (isset($_POST['remember'])) {

    $token = md5($user->id.$user->password.time());
    
    $sql = 'UPDATE user SET password_cookie_token = :token WHERE email = :email';
    $statement = $pdo->prepare($sql);
    $updateToken = $statement->execute([':token' => $token, ':email' => $user->email]);
 
    if (!$updateToken) {   
        displayError('Ошибка функционала \'Запомнить меня\'');
    }
 
    setcookie('password_cookie_token', $token, time() + (1000 * 60 * 60 * 24 * 30));
 
} else {
 
    if (isset($_COOKIE['password_cookie_token'])) {
        updateToken($pdo);      
    }
     
}

header('Location: /index.php');
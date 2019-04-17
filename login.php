<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/dbconn.php');

if(isset($_SESSION['email'])) {
    header('Location: /index.php');
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if(empty($email) || empty($password)) {
    
    $errorMessage = 'Неверный логин или пароль';
    include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
    exit();
    
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
    $errorMessage = 'Email адрес указан неверно';
    include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
    exit();
    
}

$sql = 'SELECT name, email, password FROM user WHERE email = :email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);

$user = $statement->fetch(PDO::FETCH_OBJ);

if(!$user || !password_verify($password, $user->password)) {
    
    $errorMessage = 'Неверный логин или пароль';
    include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
    exit();
    
}

$_SESSION['logged_user'] = $email;

if(isset($_POST['remember'])) {
    setcookie("username", password_hash($user->name, PASSWORD_DEFAULT), time() + 3600 * 72);
}

header('Location: /list.php');
exit();
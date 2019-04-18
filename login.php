<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/dbconn.php');

if(!isset($_SESSION['user_id'])) {
    header('Location: /list.php');
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

$sql = 'SELECT * FROM user WHERE email = :email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);
$user = $statement->fetch(PDO::FETCH_OBJ);

if(!$user || !password_verify($password, $user->password)) {
    
    $errorMessage = 'Неверный логин или пароль';
    include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
    exit();
    
}

$_SESSION['user_id'] = $user->id;
$_SESSION['user_email'] = $user->email;

if(isset($_POST['remember'])) {
    setcookie("username", password_hash($user->name, PASSWORD_DEFAULT), time() + 3600 * 72);
}

header('Location: /index.php');
exit();
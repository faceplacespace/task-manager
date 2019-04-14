<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/dbconn.php');

if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['email'])){
            
    include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
    exit();
    
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql = 'SELECT id FROM user WHERE email=:email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);
$user = $statement->fetchColumn();

if($user) {
    
    $errorMessage = 'Пользователь с таким email уже существует';
    include 'errors.php';
    exit();
    
}

$sql = 'INSERT INTO user (name, email, password) VALUES (:name, :email, :password)';
$statement = $pdo->prepare($sql);

$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

$result = $statement->execute($_POST);

if(!result) {
    
    $errorMessage = 'Ошибка регистрации';
    include '/errors.php';
    exit();
    
}

header('Location: /login-form.php');
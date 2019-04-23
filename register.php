<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/components/components.php');

if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
}

if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {   
    displayError();
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql = 'SELECT id FROM user WHERE email=:email';
$statement = $pdo->prepare($sql);
$statement->execute([':email' => $email]);
$user = $statement->fetchColumn();

if ($user) {
    displayError('Пользователь с таким email уже существует');
}

$sql = 'INSERT INTO user (name, email, password) VALUES (:name, :email, :password)';
$statement = $pdo->prepare($sql);

$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

$result = $statement->execute($_POST);

if (!result) {
    displayError('Ошибка регистрации');
}

header('Location: /login-form.php');
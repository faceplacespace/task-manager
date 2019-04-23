<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/components/dbconn.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/components/functions.php');

session_start();

if (!isset($_SESSION['user_id']) && isset($_COOKIE['password_cookie_token']) && !empty($_COOKIE['password_cookie_token'])) {
    
    $sql = 'SELECT * FROM user WHERE password_cookie_token = :token';
    $statement = $pdo->prepare($sql);
    $statement->execute([':token' => $_COOKIE['password_cookie_token']]);
    $user = $statement->fetch(PDO::FETCH_OBJ);
 
    if (!$user) {
        displayError('Ошибка функционала \'Запомнить меня\'');
    }
             
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
 
}
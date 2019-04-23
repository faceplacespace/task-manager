<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/components/components.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login-form.php');
}

if (isset($_COOKIE['password_cookie_token'])) {   
    updateToken($pdo);
}

unset($_SESSION['user_id'], $_SESSION['user_email']);

header('Location: login-form.php');
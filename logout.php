<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/dbconn.php');

if(!isset($_SESSION['user_id'])) {
    header('Location: login-form.php');
}

unset($_SESSION['user_id'], $_SESSION['user_email']);

header('Location: login-form.php');
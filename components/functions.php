<?php

function displayError ($errorMessage = 'Заполните все поля.') {
    
    include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
    exit();
    
}

function uploadImage() {

    $taskImage = $_FILES['task-image'];
    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
    $fileName = md5($taskImage['name'].time()).'.'.pathinfo($taskImage['name'], PATHINFO_EXTENSION);;
    $uploadFile = $uploadDir.$fileName;

    if ($taskImage['error'] === 2) {
        displayError('Размер загружаемого файла не должен превышать 30 Мб');
    }

    $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_WEBP);
    $detectedType = exif_imagetype($taskImage['tmp_name']);

    if (!in_array($detectedType, $allowedTypes)) {
        displayError('Формат загружаемого файла должен соответствовать одному из вариантов: JPG, PNG, GIF, WEBP');
    }

    if (!move_uploaded_file($taskImage['tmp_name'], $uploadFile)) {
        displayError('Ошибка при загрузке файла.');
    }
    
    return $fileName;
    
}

function updateToken($pdo) {
    
    $sql = 'UPDATE user SET password_cookie_token = null WHERE password_cookie_token = :token';
    $statement = $pdo->prepare($sql);
    $updateToken = $statement->execute([':token' => $_COOKIE['password_cookie_token']]);
     
    if (!$updateToken) { 
        displayError('Ошибка функционала \'Запомнить меня\'');
    } else {
        setcookie('password_cookie_token', '', time() - 3600);
    }
    
}
<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/dbconn.php');

if(!isset($_SESSION['user_id'])) {
    
    header('Location: /login-form.php');
    exit;
    
}

if(empty($_POST['title'])) {
    
    include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
    exit();
    
}

$title = trim($_POST['title']);
$description = trim($_POST['description']);

if(is_uploaded_file($_FILES['task-image']['tmp_name'])){

    $taskImage = $_FILES['task-image'];
    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
    $fileName = md5($taskImage['name'].time()).'.'.pathinfo($taskImage['name'], PATHINFO_EXTENSION);;
    $uploadFile = $uploadDir.$fileName;

    if($taskImage['error'] === 2) {

        $errorMessage = 'Размер загружаемого файла не должен превышать 30 Мб';
        include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
        exit();

    }

    $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_WEBP);
    $detectedType = exif_imagetype($taskImage['tmp_name']);

    if(!in_array($detectedType, $allowedTypes)) {

        $errorMessage = 'Формат загружаемого файла должен соответствовать одному из вариантов: JPG, PNG, GIF, WEBP';
        include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
        exit();

    }

    if (!move_uploaded_file($taskImage['tmp_name'], $uploadFile)) {

        $errorMessage = 'Ошибка при загрузке файла.';
        include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
        exit();

    }
    
}

$sql = 'INSERT INTO task (user_id, title, description, image) VALUES (:user_id, :title, :description, :image)';
$statement = $pdo->prepare($sql);
$task = $statement->execute(['user_id' => $_SESSION['user_id'], ':title' => $title, ':description' => $description, ':image' => $fileName]);

if($task) {
    
    header('Location: /index.php');
    exit();

} else {
    
    $errorMessage = 'Ошибка при добавлении задачи.';
    include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
    exit();
    
}
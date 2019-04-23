<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/components/components.php');

if (!isset($_SESSION['user_id'])) {
    
    header('Location: /login-form.php');
    exit;
    
}

if (empty($_POST['title'])) {
    displayError();
}

$title = trim($_POST['title']);
$description = trim($_POST['description']);

if (is_uploaded_file($_FILES['task-image']['tmp_name'])) {
    $fileName = uploadImage();
}

$sql = 'INSERT INTO task (user_id, title, description, image) VALUES (:user_id, :title, :description, :image)';
$statement = $pdo->prepare($sql);
$task = $statement->execute(['user_id' => $_SESSION['user_id'], ':title' => $title, ':description' => $description, ':image' => $fileName]);

if ($task) {
    
    header('Location: /index.php');
    exit();

} else {  
    displayError('Ошибка при добавлении задачи.');
}
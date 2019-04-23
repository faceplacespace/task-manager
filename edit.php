<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/components/components.php');

if (!isset($_SESSION['user_id'])) {
    
    header('Location: /login-form.php');
    exit;
    
}

if (empty($_POST['task-id']) || empty($_POST['title'])) {   
    displayError(); 
}

$taskId = trim($_POST['task-id']);
$title = trim($_POST['title']);
$description = trim($_POST['description']);

if (is_uploaded_file($_FILES['task-image']['tmp_name'])) {
    $fileName = uploadImage();
}

//$sql = 'SELECT image FROM task WHERE id = :id';
//$statement = $pdo->prepare($sql);
//$statement->execute(['id' => $taskId]);
//$task = $statement->fetch(PDO::FETCH_OBJ);

$currentImage = getImageByTaskID($pdo, $taskId);

$sql = 'UPDATE task SET title = :title, description = :description, image = :image WHERE id = :id';
$statement = $pdo->prepare($sql);
$task = $statement->execute([':id' => $taskId, ':title' => $title, ':description' => $description, ':image' => $fileName]);

if ($task) {
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$currentImage)) {
        unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$currentImage);
    }

    header('Location: /index.php');

} else {
    displayError('Ошибка при изменении задачи.');  
}
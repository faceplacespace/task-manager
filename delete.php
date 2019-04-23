<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/components/components.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: login-form.php');
    }
    
    $taskId = $_GET['id'];

    $sql = 'DELETE FROM task WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $deleteTask = $statement->execute([':id' => $taskId]);
    
    if ($deleteTask) {
        
        if (file_exists('/uploads/'.$currentImage)) {
            unlink('/uploads/'.$currentImage);
        }

        header('Location: /index.php');
        exit();

    } else {     
        displayError('Ошибка при удалении задачи.');
    }
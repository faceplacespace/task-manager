<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/components/components.php');

    if (!isset($_SESSION['user_id'])) {
        header('Location: login-form.php');
    }
    
    $taskId = $_GET['id'];
    
    $currentImage = getImageByTaskID($pdo, $taskId);

    $sql = 'DELETE FROM task WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $deleteTask = $statement->execute([':id' => $taskId]);
    
    if ($deleteTask) {
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$currentImage)) {
            unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$currentImage);
        }

        header('Location: /index.php');
        exit();

    } else {     
        displayError('Ошибка при удалении задачи.');
    }
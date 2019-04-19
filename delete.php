<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/dbconn.php');

    if(!isset($_SESSION['user_id'])) {
        header('Location: login-form.php');
    }
    
    $taskId = $_GET['id'];

    $sql = 'DELETE FROM task WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $deleteTask = $statement->execute([':id' => $taskId]);
    
    if($deleteTask) {

        header('Location: /index.php');
        exit();

    } else {

        $errorMessage = 'Ошибка при удалении задачи.';
        include($_SERVER['DOCUMENT_ROOT'].'/errors.php');
        exit();

    }
<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/dbconn.php');

    if(!isset($_SESSION['user_id'])) {
        header('Location: login-form.php');
    }
    
    $taskId = $_GET['id'];

    $sql = 'SELECT * FROM task WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $taskId]);
    $task = $statement->fetch(PDO::FETCH_OBJ);
    
    $imagePath = '/assets/img/no-image.jpg';
    
    if($task->image !== null){
        $imagePath = '/uploads/'.$task->image;
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Show</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

  </head>

  <body>
    <div class="form-wrapper text-center">
        <img src="<?=$imagePath;?>" alt="" width="400">
      <h2><?=$task->title;?></h2>
      <p><?=$task->description;?></p>
    </div>
  </body>
</html>

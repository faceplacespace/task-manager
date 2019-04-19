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

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Edit Task</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

  </head>

  <body>
    <div class="form-wrapper text-center">
        <form class="form-signin" action="/edit.php" method="post" enctype="multipart/form-data">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Изменить запись</h1>
        <input type="hidden" name="taskId" value="<?=$task->id?>">
        <label for="inputTitle" class="sr-only">Название</label>
        <input type="text" id="inputTitle" name="title" class="form-control" placeholder="Название" required value="<?=$task->title?>">
        <label for="inputDescription" class="sr-only">Описание</label>
        <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Описание"><?=$task->description?></textarea>
        <input type="file" name="task-image">
        <img src="/uploads/<?=$task->image?>" alt="" width="300" class="mb-3">
        <button class="btn btn-lg btn-success btn-block" type="submit">Редактировать</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>

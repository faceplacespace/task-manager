
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Errors</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="container text-center mt-5">
      <p><?=$errorMessage?></p>
      <a href="<?=$_SERVER['HTTP_REFERER'];?>">Назад</a>
    </div>
  </body>
</html>

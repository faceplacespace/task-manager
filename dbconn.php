<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'].'/config/dbparams.php';
$params = include($paramsPath);

$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
$pdo = new PDO($dsn, $params['user'], $params['password']);

session_start();

return $pdo;
<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/components/functions.php');

$paramsPath = $_SERVER['DOCUMENT_ROOT'].'/config/dbparams.php';
$params = include($paramsPath);

$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
$pdo = new PDO($dsn, $params['user'], $params['password']);

return $pdo;
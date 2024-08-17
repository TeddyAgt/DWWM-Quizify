<?php

$dns = "mysql:host=localhost;dbname=quizify";
$usr = getenv("usr");
$pwd = getenv("pwd");


$pdo = new PDO($dns, $usr, $pwd, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

return $pdo;

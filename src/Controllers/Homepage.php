<?php

require("vendor/autoload.php");

use App\Models\Quiz\QuizDB;

$title =  "Accueil";
$quizList = (new QuizDB($pdo))->getAllQuiz();
$css = "<link rel='stylesheet' href='public/css/index.css'>";
$content = "templates/home/home.php";
$js = "<script src='public/js/index.js'></script>";
require("templates/layout.php");

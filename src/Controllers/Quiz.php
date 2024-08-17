<?php

use App\Models\Quiz\QuizDB;

require("vendor/autoload.php");

$quizId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!$quizId) {
    header("Location: index.php");
}

$quiz = (new QuizDB($pdo))->getQuiz($quizId);
$title = $quiz->title;
$css = "<link rel='stylesheet' href='public/css/quiz.css'>";
$content = "templates/quiz/quiz.php";
$js = "<script type='module' src='public/js/quiz.js'></script>";
require("templates/layout.php");

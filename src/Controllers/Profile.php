<?php

require("vendor/autoload.php");

use App\Models\Quiz\{QuizDB, ScoreDB};


if ($user->isAdmin) {
  $quizList = (new QuizDB($pdo))->getQuizByUser($user->id);
  $results = (new ScoreDB($pdo))->getScoresByAuthor($user->id);
} else {
  $participations = (new ScoreDB($pdo))->getScoresByPlayer($user->id);
}

$title = "$user->username - Page de profil";
$css = "
  <link rel='stylesheet' href='public/css/forms.css'>
  <link rel='stylesheet' href='public/css/profile.css'>
";
$content = "templates/profile/profile.php";
$js = "<script src='public/js/quiz-creation.js'></script>";
require("templates/layout.php");

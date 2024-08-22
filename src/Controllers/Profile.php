<?php

require("vendor/autoload.php");

use App\Models\Quiz\QuizDB;
use App\Models\Quiz\ScoreDB;

if ($user->isAdmin) {
    $quizList = (new QuizDB($pdo))->getQuizByUser($user->id);
} else {
    $participations = (new ScoreDB($pdo))->getScoresByPlayer($user->id);
}

$title = "$user->username - Page de profil";
$css = $user->isAdmin ? "
    <link rel='stylesheet' href='public/css/forms.css'>
    <link rel='stylesheet' href='public/css/profile.css'>
    <link rel='stylesheet' href='public/css/admin.css'>
" : "
    <link rel='stylesheet' href='public/css/forms.css'>
    <link rel='stylesheet' href='public/css/profile.css'>
";
$content =  "templates/profile/profile.php";
$js = $user->isAdmin ? "
    <script src='public/js/profile.js'></script>
    <script src='public/js/quiz-creation.js'></script>
    <script src='public/js/admin.js'></script>
" : "<script src='public/js/profile.js'></script>";

require("templates/layout.php");

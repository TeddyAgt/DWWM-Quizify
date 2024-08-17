<?php

require("vendor/autoload.php");

use App\Models\Quiz\QuizDB;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit;
}

$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);

(new QuizDB($pdo))->createQuiz([
    "title" => $title,
    "author" => $user->id,
    "description" => $description
]);

header("Location: index.php?action=profile");

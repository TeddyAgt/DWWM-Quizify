<?php
require("vendor/autoload.php");

use App\Models\Quiz\QuizDB;

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}

$quizId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT) ?? "";

if ($quizId) {
    $quiz = (new QuizDB($pdo))->getQuiz($quizId);
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($quiz);
}

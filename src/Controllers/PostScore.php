<?php

use App\Models\Quiz\ScoreDB;

require("vendor/autoload.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit;
}

$score = json_decode(file_get_contents("php://input"), true);

if ($score) {
  (new ScoreDB($pdo))->createScore([
    ...$score,
    "quizPlayer" => $user->id
  ]);
} else {
  http_response_code(400);
  exit;
}

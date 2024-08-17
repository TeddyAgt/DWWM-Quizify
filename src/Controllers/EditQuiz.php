<?php

use App\Models\Quiz\AnswerDB;
use App\Models\Quiz\QuestionDB;
use App\Models\Quiz\QuizDB;

require("vendor/autoload.php");

$quizId = (int) filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$edit = (int) filter_input(INPUT_GET, "edit", FILTER_SANITIZE_NUMBER_INT) ?? 3;
$edit = $edit === 0 ? 3 : $edit;
$questionId = (int) filter_input(INPUT_GET, "question", FILTER_SANITIZE_NUMBER_INT);

if (!$quizId) {
    header("Location: index.php?action=profile");
}

if ($questionId) {
    $question = (new QuestionDB($pdo))->getQuestion($questionId);
}

$quiz = (new QuizDB($pdo))->getQuiz($quizId);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    switch ($edit) {
            // Modification du titre
        case "1":
            $input = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $title = $input["title"] ?? $quiz->title;
            $description = $input["description"] ?? $quiz->description;
            (new QuizDB($pdo))->updateQuiz([
                "id" => $quiz->id,
                "title" => $title,
                "description" => $description
            ]);
            header("Location: index.php?action=editQuiz&id=$quizId");
            break;

            // Modification d'une question
        case "2":
            $inputs = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $inputValues = array_values($inputs);

            (new QuestionDB($pdo))->updateQuestion([
                "id" => $questionId,
                "text" => $inputValues[0]
            ]);

            for ($i = 1; $i < count($inputValues) - 1; $i++) {
                (new AnswerDB($pdo))->updateAnswer([
                    "id" => $question->answers[$i - 1]->id,
                    "text" => $inputValues[$i],
                ]);
            }
            header("Location: index.php?action=editQuiz&id=$quizId");
            break;

            // Ajout d'une question
        case "3":
            $inputs = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $inputValues = array_values($inputs);

            $questionId = (new QuestionDB($pdo))->createQuestion([
                "quizId" => $quizId,
                "text" => $inputValues[0]
            ]);

            $answerDB = new AnswerDB($pdo);
            $answerDB->createOneAnswer([
                "quizId" => $quizId,
                "questionId" => $questionId,
                "text" => $inputValues[1],
                "isTrue" => 1
            ]);

            for ($i = 2; $i < count($inputValues) - 1; $i++) {
                $answerDB->createOneAnswer([
                    "quizId" => $quizId,
                    "questionId" => $questionId,
                    "text" => $inputValues[$i],
                    "isTrue" => 0
                ]);
            }
            header("Location: index.php?action=editQuiz&id=$quizId");
            break;

            // Supression d'une question
        case "4":
            (new QuestionDB($pdo))->deleteQuestion($questionId);
            header("Location: index.php?action=editQuiz&id=$quizId");
            break;

        case "5":
            // Supression d'un quiz
            (new QuizDB($pdo))->deleteQuiz($quizId);
            header("Location: index.php?action=profile");
            break;
    }
}

$title = 'Éditer "' . $quiz->title . '"';
$css = "
  <link rel='stylesheet' href='public/css/index.css'>
  <link rel='stylesheet' href='public/css/forms.css'>
  <link rel='stylesheet' href='public/css/edit-quiz.css'>
";
$content = "templates/profile/edit-quiz.php";
$js = "<script src='public/js/edit-quiz.js'></script>";
require("templates/layout.php");

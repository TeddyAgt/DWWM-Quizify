<?php

namespace App\Controllers\Homepage;

require_once("src/tools/database-connection.php");
require_once("src/Models/User.php");
require_once("src/Models/Session.php");
require_once("src/Models/Quiz.php");
require_once("src/Models/Question.php");
require_once("src/Models/Answer.php");
require_once("src/Models/Score.php");

use App\Models\User\User;
use App\Models\User\UserDB;
use App\Models\Session\SessionDB;
use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizDB;
use App\Models\Question\Question;
use App\Models\Question\QuestionDB;
use App\Models\Answer\Answer;
use App\Models\Answer\AnswerDB;

class Homepage
{

  public function getPage()
  {
    global $pdo;
    $title =  "Accueil";
    // fetch les quiz
    $view =  "templates/home/home.php";
    // require("templates/layout.php");

    // Tests
    $test = (new QuizDB($pdo))->getQuiz(1);
    var_dump($test);
  }
}

<?php

namespace App\Controllers;

require("vendor/autoload.php");

use App\Models\Quiz\QuizDB;

class Homepage
{

  public function getPage($user)
  {
    global $pdo;
    $title =  "Accueil";

    //  Vérifier si utilisateur connecté

    $test = (new QuizDB($pdo))->getAllQuiz();
    $content =  "templates/home/home.php";
    require("templates/layout.php");

    // Tests
  }
}

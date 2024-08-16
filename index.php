<?php

require_once("src/Tools/database-connection.php");
require_once("src/Models/User.php");
require_once("src/Models/Session.php");
require_once("src/Controllers/Homepage.php");
require_once("src/Controllers/Login.php");

use App\Controllers\Homepage\Homepage;
// use App\Controllers\Login\Login;
use App\Models\User\UserDB;
use App\Models\Session\SessionDB;

$user = null;
if (($userId = (new SessionDB($pdo))->isLoggedIn())) {
  $user = (new UserDB($pdo))->getUserById($userId);
}

// Router
try {

  if (isset($_GET["action"])) {
    $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    switch ($action) {
      case 'signup':
        if ($user) {
          header("Location: index.php.action=profile");
        }

        require_once("src/Controllers/Signup.php");
        break;

      case 'login':
        if ($user) {
          header("Location: index.php.action=profile");
        }

        require_once("src/Controllers/Login.php");
        break;

      case 'logout':
        if (!$user) {
          header("index.php");
        }
        break;

      case 'profile':
        if (!$user) {
          header("index.php?action=login");
        }
        break;

      case 'quiz':
        // 
        break;

      case 'createQuiz':
        if (!$user) {
          header("index.php?action=login");
        }
        break;

      case 'editQuiz':
        if (!$user) {
          header("index.php?action=login");
        }
        break;

      case 'getQuiz':
        // 
        break;

      case 'postScore':
        // 
        break;

      default:
        throw new Exception("La page demandée n'existe pas", 404);
        break;
    }
  } else {
    (new Homepage())->getPage($user);
  }
} catch (Exception $e) {
  $errorMessage = $e->getMessage();

  require("templates/error.php");
}

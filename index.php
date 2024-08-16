<?php
require("vendor/autoload.php");
// require_once("src/Tools/database-connection.php");

use App\Controllers\Homepage;
use App\Models\User\{UserDB, SessionDB};

$user = null;
if (($userId = (new SessionDB($pdo))->isLoggedIn())) {
  $user = (new UserDB($pdo))->getUserById($userId);
}

// Router
// try {

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
      $user = $user;
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

      require("src/Controllers/Profile.php");
      break;

    case 'quiz':
      // 
      break;

    case 'createQuiz':
      if (!$user) {
        header("index.php?action=login");
      }
      echo "création quiz réussie";
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
// } catch (Exception $e) {
//   $errorMessage = $e->getMessage();

//   require("templates/error.php");
// }

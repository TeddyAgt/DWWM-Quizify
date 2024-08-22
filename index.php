<?php
require("vendor/autoload.php");
require_once("src/Tools/database-connection.php");

use App\Models\User\SessionDB;
use App\Models\User\UserDB;

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
                    header("Location: index.php?action=profile");
                }

                require_once("src/Controllers/Signup.php");
                break;

            case 'login':
                if ($user) {
                    header("Location: index.php?action=profile");
                }
                // $user = $user;
                require_once("src/Controllers/Login.php");
                break;

            case 'logout':
                if (!$user) {
                    header("Location: index.php");
                }

                require_once("src/Controllers/Logout.php");
                break;

            case 'profile':
                if (!$user) {
                    header("Location: index.php?action=login");
                }

                require("src/Controllers/Profile.php");
                break;

            case 'quiz':
                if (!$user) {
                    header("Location: index.php?action=login");
                }

                require("src/Controllers/Quiz.php");
                break;

            case 'createQuiz':
                if (!$user) {
                    header("Location: index.php?action=login");
                }

                require("src/Controllers/CreateQuiz.php");
                break;

            case 'editQuiz':
                if (!$user || !$user->isAdmin) {
                    header("Location: index.php?action=login");
                }

                require("src/Controllers/EditQuiz.php");
                break;

            case 'getQuiz':
                if (!$user) {
                    http_response_code(401);
                    header("Location: /");
                }
                require("src/Controllers/GetQuiz.php");
                break;

            case 'postScore':
                if (!$user) {
                    http_response_code(401);
                    header("Location: /");
                }
                require("src/Controllers/PostScore.php");
                break;

            case 'legals':
                $css = "<link rel='stylesheet' href='public/css/legals.css'>";
                $content = "templates/legals.php";
                require("templates/layout.php");
                break;

            default:
                throw new Exception("La page demandée n'existe pas", 404);
                break;
        }
    } else {
        require("src/Controllers/Homepage.php");
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();

    require("templates/error.php");
}

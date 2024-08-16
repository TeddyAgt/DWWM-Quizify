<?php
require("vendor/autoload.php");

use App\Models\User\{UserDB, SessionDB};
use App\Tools\FormErrorHandler;

$title = "Connexion";
$handler = new FormErrorHandler("login");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
  $password = $_POST["password"] ?? "";

  $handler->controlField("username", $username);
  $handler->controlField("password", $password);

  if ($handler->isOk()) {
    $user = (new UserDB($pdo))->getUserByUsername($username);
    var_dump($user);
    if ($handler->controlField("user", $user->username ?? "")) {
      if ($handler->controlField("passwordValidation", $password, $user->getPassword())) {
        (new SessionDB($pdo))->createSession($user->id);
        header("Location: index.php?action=profile");
      }
    }
  }
}

$css = '<link rel="stylesheet" href="public/css/forms.css">';
$content = "templates/userForm/login.php";
$js = '<script src="public/js/form-utils.js"></script>';
require("templates/layout.php");

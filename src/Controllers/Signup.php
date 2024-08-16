<?php

use App\Models\Session\SessionDB;
use App\Models\User\UserDB;

require_once("src/tools/database-connection.php");
require_once("src/tools/FormErrorHandler.php");
require_once("src/Models/User.php");
require_once("src/Models/Session.php");

$title = "Inscription";
$handler = new FormErrorHandler("login");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS) ?? "";
  $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL) ?? "";
  $password = $_POST["password"];
  $confirmation = $_POST["confirmation"];

  $handler->controlField("username", $username);
  $handler->controlField("email", $email);
  $handler->controlField("password", $password);
  $handler->controlField("confirmation", $confirmation, $password);
  var_dump($handler->errors);
  if ($handler->isOK()) {
    (new UserDB($pdo))->createUser([
      "username" => $username,
      "email" => $email,
      "password" => $password
    ]);
    header("Location: index.php?action=login");
  }
}

$css = '<link rel="stylesheet" href="public/css/forms.css">';
$content = "templates/userForm/signup.php";
$js = '<script src="public/js/form-utils.js"></script>';
require("templates/layout.php");

<?php

use App\Models\User\UserDB;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit;
}

$userId = (int) filter_input(INPUT_POST, "user-id", FILTER_SANITIZE_NUMBER_INT) ?? "";

if (!$userId || $userId !== $user->id) {
    http_response_code(403);
    exit;
}

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? "";
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? "";

if (!$username || !$email) {
    http_response_code(400);
    exit;
}

(new UserDB($pdo))->updateUser([
    "id" => $user->id,
    "username" => $username,
    "email" => $email
]);

header("Location: index.php?action=profile");

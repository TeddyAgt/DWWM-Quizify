<?php

use App\Models\User\UserDB;

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    exit;
}

$field = filter_input(INPUT_GET, "field", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? "";
$value = filter_input(INPUT_GET, "value", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? "";

if (!$field || !$value) {
    http_response_code(400);
    exit;
}

if ($field === "username") {
    $exists = (new UserDB($pdo))->usernameExists($value);
} elseif ($field === "email") {
    $exists = (new UserDB($pdo))->emailExists($value);
} else {
    http_response_code(400);
    exit;
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode(["exists" => $exists]);

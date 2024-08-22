<?php

namespace App\Tools;

use App\Models\User\UserDB;

class FormErrorHandler
{
    public array $errors;

    public const string ERROR_REQUIRED = "Ce champs est requis";
    public const string ERROR_USERNAME_TOO_SHORT = "Le nom d'utilisateur doit faire 5 caractères minimum";
    public const string ERROR_USERNAME_TOO_LONG = "Le nom d'utilisateur doit faire 32 caractères maximum";
    public const string ERROR_USERNAME_ALREADY_EXISTS = "Ce nom d'utilisateur n'est pas disponnible";
    public const string ERROR_USERNAME_UNKNOWN = "Le nom d'utilisateur est inconnu";
    public const string ERROR_EMAIL_INVALID = "L'adresse mail n'est pas valide";
    public const string ERROR_EMAIL_ALREADY_EXISTS = "Il y a déjà un compte avec cette adresse mail";
    public const string ERROR_PASSWORD_TOO_SHORT = "Le mot de passe doit faire 8 caractères minimum";
    public const string ERROR_PASSWORD_WRONG = "Le mot de passe est incorrect";
    public const string ERROR_PASSWORD_WRONG_CONFIRMATION = "Le mot de passe de confirmation ne correspond pas";

    public function __construct(string $formType)
    {
        switch ($formType) {
            case 'signup':
                $this->errors = [
                    "username" => "",
                    "email" => "",
                    "password" => "",
                    "confirmation" => ""
                ];
                break;

            case 'login':
                $this->errors = [
                    "username" => "",
                    "password" => ""
                ];
                break;

            default:
                # code...
                break;
        }
    }

    public function controlField(string $field, $value, $controlValue = null)
    {
        global $pdo;
        switch ($field) {
            case 'username':
                if (!$value) {
                    $this->setError($field, FormErrorHandler::ERROR_REQUIRED);
                    return false;
                } elseif (mb_strlen($value) < 5) {
                    $this->setError($field, FormErrorHandler::ERROR_USERNAME_TOO_SHORT);
                    return false;
                }
                return true;
                break;

            case 'email':
                if (!$value) {
                    $this->setError($field, FormErrorHandler::ERROR_REQUIRED);
                    return false;
                } elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->setError("username", FormErrorHandler::ERROR_USERNAME_TOO_SHORT);
                    return false;
                } elseif ((new UserDB($pdo))->getUserByEmail($value)) {
                    $this->setError($field, FormErrorHandler::ERROR_EMAIL_ALREADY_EXISTS);
                    return false;
                }
                return true;
                break;

            case 'password':
                if (!$value) {
                    $this->setError($field, FormErrorHandler::ERROR_REQUIRED);
                    return false;
                } elseif (mb_strlen($value) < 8) {
                    $this->setError($field, FormErrorHandler::ERROR_PASSWORD_TOO_SHORT);
                    return false;
                }
                return true;
                break;

            case 'confirmation':
                if (!$value) {
                    $this->setError($field, FormErrorHandler::ERROR_REQUIRED);
                    return false;
                } elseif ($value !== $controlValue) {
                    $this->setError($field, FormErrorHandler::ERROR_PASSWORD_WRONG_CONFIRMATION);
                    return false;
                }
                return true;
                break;

            case 'user':
                if (!$value) {
                    $this->setError("username", FormErrorHandler::ERROR_USERNAME_UNKNOWN);
                    return false;
                }
                return true;
                break;

            case 'passwordValidation':
                if (!password_verify($value, $controlValue)) {
                    $this->setError("password", FormErrorHandler::ERROR_PASSWORD_WRONG);
                    return false;
                }
                return true;
                break;
        }
    }

    public function isOK(): bool
    {
        return (empty(array_filter($this->errors, fn($e) => $e !== "")));
    }

    public function setError($field, $error): void
    {
        $this->errors["$field"] = $error;
    }

    public function hasError(string $field): bool
    {
        return ($this->errors["$field"] !== "");
    }

    public function getError(string $field): string
    {
        return $this->errors["$field"];
    }
}

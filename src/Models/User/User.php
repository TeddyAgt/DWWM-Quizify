<?php

namespace App\Models\User;

class User
{
  public int $id;
  public string $username;
  public string $email;
  private string $_password;
  public bool $isAdmin;

  public function __construct(array $user)
  {
    $this->id = $user["id"];
    $this->username = $user["username"];
    $this->email = $user["email"];
    $this->_password = $user["password"];
    $this->isAdmin = $user["is_admin"];
  }

  public function getPassword(): string
  {
    return $this->_password;
  }

  public function calmDown(bool $isTrying): void
  {
    echo $isTrying ? "Trying to calm down..." : "Exploding !";
  }
}

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

class userDB
{
  private \PDOStatement $statementCreateOne;
  private \PDOStatement $statementReadOneById;
  private \PDOStatement $statementReadOneByUsername;
  private \PDOStatement $statementReadOneByEmail;

  public function __construct(private \PDO $pdo)
  {

    $this->statementCreateOne = $pdo->prepare("
      INSERT INTO Users (username, email, password)
      VALUES (:username, :email, :password);
    ");

    $this->statementReadOneById = $pdo->prepare("
      SELECT *
      FROM Users
      WHERE id = :userId;
    ");

    $this->statementReadOneByUsername = $pdo->prepare("
      SELECT *
      FROM Users
      WHERE username = :username;
    ");

    $this->statementReadOneByEmail = $pdo->prepare("
      SELECT *
      FROM Users
      WHERE email = :email;
    ");
  }

  public function createUser(array $user): bool
  {
    $hashedPassword = password_hash($user["password"], PASSWORD_ARGON2I);
    $this->statementCreateOne->bindValue(":username", $user["username"]);
    $this->statementCreateOne->bindValue(":email", $user["email"]);
    $this->statementCreateOne->bindValue(":email", $user["email"]);
    $this->statementCreateOne->bindValue(":password", $hashedPassword);
    return $this->statementCreateOne->execute();
  }

  public function getUserById(int $userId): User|false
  {
    $this->statementReadOneById->bindValue("userId", $userId);
    $this->statementReadOneById->execute();
    if (($data = $this->statementReadOneById->fetch())) {
      return new User($data);
    }
    return false;
  }

  public function getUserByUsername(string $username): User|false
  {
    $this->statementReadOneById->bindValue("userId", $username);
    $this->statementReadOneById->execute();
    if (($data = $this->statementReadOneById->fetch())) {
      return new User($data);
    }
    return false;
  }

  public function getUserByEmail(string $email): User|false
  {
    $this->statementReadOneById->bindValue("userId", $email);
    $this->statementReadOneById->execute();
    if (($data = $this->statementReadOneById->fetch())) {
      return new User($data);
    }
    return false;
  }
}

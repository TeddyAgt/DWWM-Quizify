<?php

namespace App\Models\User;

class SessionDB
{
    private \PDOStatement $statementCreateOne;
    private \PDOStatement $statementReadOne;
    private \PDOStatement $statementDeleteOne;

    public function __construct(private \PDO $pdo)
    {
        $this->statementCreateOne = $pdo->prepare("
      INSERT INTO Sessions
      VALUES (:sessionId, :userId);
    ");

        $this->statementReadOne = $pdo->prepare("
      SELECT user_id
      FROM Sessions
      WHERE id = :sessionId;
    ");

        $this->statementDeleteOne = $pdo->prepare("
      DELETE FROM Sessions
      WHERE id = :sessionId;
    ");
    }

    public function createSession(int $userId): void
    {
        $sessionId = bin2hex(random_bytes(32));
        $this->statementCreateOne->bindValue(":sessionId", $sessionId);
        $this->statementCreateOne->bindValue("userId", $userId);
        $this->statementCreateOne->execute();

        $signature = hash_hmac("sha256", $sessionId, getenv("secret"));
        setcookie("session", $sessionId, time() + 60 * 60 * 24 * 14, "", "", false, false);
        setcookie("signature", $signature, time() + 60 * 60 * 24 * 14, "", "", false, false);
    }

    public function isLoggedIn(): int | bool
    {
        $sessionId = $_COOKIE["session"] ?? "";
        $signature = $_COOKIE["signature"] ?? "";

        if ($sessionId && $signature) {
            $hash = hash_hmac("sha256", $sessionId, getenv("secret"));
            if (hash_equals($hash, $signature)) {
                $this->statementReadOne->bindValue(":sessionId", $sessionId);
                $this->statementReadOne->execute();
                $userId = $this->statementReadOne->fetch()["user_id"];
            }
        }
        return $userId ?? false;
    }

    public function deleteSession(): void
    {
        $sessionId = $_COOKIE["session"] ?? "";
        $this->statementDeleteOne->bindValue(":sessionId", $sessionId);
        $this->statementDeleteOne->execute();
        setcookie("session", "", time() - 1);
        setcookie("signature", "", time() - 1);
    }
}

<?php

namespace App\Models\Quiz;

class ScoreDB
{
    private \PDOStatement $statementCreateOne;
    private \PDOStatement $statementReadAllByPlayer;
    private \PDOStatement $statementReadAllByAuthor;

    public function __construct(private \PDO $pdo)
    {
        $this->statementCreateOne = $pdo->prepare("
      INSERT INTO Scores (quiz_id, quiz_player, score)
      VALUES (:quizId, :quizPlayer, :score);
    ");

        $this->statementReadAllByPlayer = $pdo->prepare("
      SELECT quiz_id, title, author, quiz_player, username, score, DATE_FORMAT(date, '%d/%m/%Y') AS date
      FROM Scores
      JOIN Quiz ON Scores.quiz_id = Quiz.id
      JOIN Users ON scores.quiz_player = Users.id
      WHERE quiz_player = :userId;
    ");

        $this->statementReadAllByAuthor = $pdo->prepare("
      SELECT quiz_id, title, author, quiz_player, username, score, DATE_FORMAT(date, '%d/%m/%Y') AS date
      FROM Scores
      JOIN Quiz ON Scores.quiz_id = Quiz.id
      JOIN Users ON scores.quiz_player = Users.id
      WHERE author = :userId;
    ");
    }

    public function createScore(array $score): bool
    {
        $this->statementCreateOne->bindValue(":quizId", $score["quizId"]);
        $this->statementCreateOne->bindValue(":quizPlayer", $score["quizPlayer"]);
        $this->statementCreateOne->bindValue(":score", $score["score"]);
        return $this->statementCreateOne->execute();
    }

    public function getScoresByPlayer(int $userId): array | false
    {
        $this->statementReadAllByPlayer->bindValue(":userId", $userId);
        $this->statementReadAllByPlayer->execute();
        if (($DBScores = $this->statementReadAllByPlayer->fetchAll())) {
            $scores = [];

            foreach ($DBScores as $DBScore) {
                array_push($scores, (new Score($DBScore)));
            }

            return $scores;
        }

        return false;
    }

    public function getScoresByAuthor(int $userId): array | false
    {
        $this->statementReadAllByAuthor->bindValue(":userId", $userId);
        $this->statementReadAllByAuthor->execute();
        if (($DBScores = $this->statementReadAllByAuthor->fetchAll())) {
            $scores = [];

            foreach ($DBScores as $DBScore) {
                array_push($scores, (new Score($DBScore)));
            }

            return $scores;
        }

        return false;
    }
}

<?php

namespace App\Models\Quiz;

class AnswerDB
{
  private \PDOStatement $statementCreateOne;
  private \PDOStatement $statementReadAllByQuiz;
  private \PDOStatement $statementReadAllByQuestion;
  private \PDOStatement $statementUpdateOne;
  private \PDOStatement $statementDeleteOneByQuiz;
  private \PDOStatement $statementDeleteOneByQuestion;

  public function __construct(private \PDO $pdo)
  {
    $this->statementCreateOne = $pdo->prepare("
      INSERT INTO Answers (quiz_id, question_id, tett, is_true)
      VALUES (:quizId, :questionId, :text, :isTrue);
    ");

    $this->statementReadAllByQuiz = $pdo->prepare("
      SELECT *
      FROM Answers
      WHERE quiz_id = :quizId;
    ");

    $this->statementReadAllByQuestion = $pdo->prepare("
      SELECT *
      FROM Answers
      WHERE question_id = :questionId;
    ");

    $this->statementUpdateOne = $pdo->prepare("
      UPDATE Answers
      SET text = :text
      WHERE id = :id;
    ");

    $this->statementDeleteOneByQuiz = $pdo->prepare("
      DELETE FROM Answers
      WHERE quiz_id = :quizId;
    ");

    $this->statementDeleteOneByQuestion = $pdo->prepare("
      DELETE FROM Answers
      WHERE question_id = :questionId;
    ");
  }

  public function createOneAnswer(array $answer): bool
  {
    $this->statementCreateOne->bindValue(":quizId", $answer["quizId"]);
    $this->statementCreateOne->bindValue(":questionId", $answer["questionId"]);
    $this->statementCreateOne->bindValue(":text", $answer["text"]);
    $this->statementCreateOne->bindValue(":isTrue", $answer["isTrue"]);
    return $this->statementCreateOne->execute();
  }

  public function createManyAnswers(array $answersList): void
  {
    foreach ($answersList as $answer) {
      $this->createOneAnswer($answer);
    }
  }

  public function getAnswersByQuiz(int $quizId): array | false
  {
    $this->statementReadAllByQuiz->bindValue(":quizId", $quizId);
    $this->statementReadAllByQuiz->execute();

    if (($DBAnswers = $this->statementReadAllByQuiz->fetchAll())) {
      $answers = [];
      foreach ($DBAnswers as $DBAnswer) {
        array_push($answers, (new Answer($DBAnswer)));
      }

      return $answers;
    }

    return false;
  }

  public function getAnswersByQuestion(int $questionId): array | bool
  {
    $this->statementReadAllByQuestion->bindValue(":questionId", $questionId);
    $this->statementReadAllByQuestion->execute();
    return $this->statementReadAllByQuestion->fetchAll();

    if (($DBAnswers = $this->statementReadAllByQuestion->fetchAll())) {
      $answers = [];
      foreach ($DBAnswers as $DBAnswer) {
        array_push($answers, (new Answer($DBAnswer)));
      }

      return $answers;
    }

    return false;
  }

  public function updateAnswer(array $answer): bool
  {
    $this->statementUpdateOne->bindValue(":text", $answer["text"]);
    $this->statementUpdateOne->bindValue(":id", $answer["id"]);
    return $this->statementUpdateOne->execute();
  }

  public function deleteAnswersByQuiz(int $quizId): bool
  {
    $this->statementDeleteOneByQuiz->bindValue(":quizId", $quizId);
    return $this->statementDeleteOneByQuiz->execute();
  }

  public function deleteAnswersByQuestion(int $questionId): bool
  {
    $this->statementDeleteOneByQuestion->bindValue(":questionId", $questionId);
    return $this->statementDeleteOneByQuestion->execute();
  }
}

<?php

namespace App\Models\Question;

require_once("src/Models/Answer.php");

use App\Models\Answer\Answer;
use App\Models\Answer\AnswerDB;

class Question
{
  public int $id;
  public string $text;
  public array $answers = [];

  public function __construct(array $question)
  {
    $this->id = $question["id"];
    $this->text = $question["text"];
  }

  public function addAnswer(Answer $answer)
  {
    array_push($this->answers, $answer);
    $this->randomizeAnswers();
  }

  private function randomizeAnswers()
  {
    shuffle($this->answers);
  }
}

class QuestionDB
{
  private \PDOStatement $statementCreateOne;
  private \PDOStatement $statementReadOne;
  private \PDOStatement $statementReadAllByQuiz;
  private \PDOStatement $statementUpdateOne;
  private \PDOStatement $statementDeleteOne;
  private \PDOStatement $statementDeleteAllByQuiz;

  public function __construct(private \PDO $pdo)
  {
    $this->statementCreateOne = $pdo->prepare("
      INSERT INTO Questions (quiz_id, text)
      VALUES (:quizID, :text);
    ");

    $this->statementReadOne = $pdo->prepare("
      SELECT *
      FROM Questions
      WHERE id = :questionId;
    ");

    $this->statementReadAllByQuiz = $pdo->prepare("
      SELECT *
      FROM Questions
      WHERE quiz_id = :quizId;
    ");

    $this->statementUpdateOne = $pdo->prepare("
      UPDATE Questions
      SET text = :text
      WHERE id = :id;
    ");

    $this->statementDeleteOne = $pdo->prepare("
      DELETE FROM Qusetions
      WHERE id = :id;
    ");

    $this->statementDeleteAllByQuiz = $pdo->prepare("
      DELETE FROM Question
      WHERE quiz_id = :quizId;
    ");
  }

  public function createQuestion(array $question): int
  {
    $this->statementCreateOne->bindValue(":quizId", $question["quizId"]);
    $this->statementCreateOne->bindValue(":text", $question["text"]);
    $this->statementCreateOne->execute();
    return $this->pdo->lastInsertId();
  }

  public function getQuestionsByQuiz(int $quizId): array | false
  {
    $this->statementReadAllByQuiz->bindValue(":quizId", $quizId);
    $this->statementReadAllByQuiz->execute();
    $this->statementReadAllByQuiz->fetchAll();

    if (($DBQuestions = $this->statementReadAllByQuiz->fetchAll())) {
      $questions = [];
      foreach ($DBQuestions as $DBquestion) {
        $question = new Question($DBquestion);
        $DBanswers = (new AnswerDB($this->pdo))->getAnswersByQuestion($question->id);

        if ($DBanswers) {
          foreach ($DBanswers as $DBanswer) {
            $question->addAnswer($DBanswer);
          }
        }

        array_push($questions, $question);
      }

      return $questions;
    }

    return false;
  }

  public function getQuestion(int $questionId): Question | false
  {
    $this->statementReadOne->bindValue(":id", $questionId);
    $this->statementReadOne->execute();

    if (($DBquestion = $this->statementReadOne->fetch())) {
      $question = new Question($DBquestion);

      $DBanswers = (new AnswerDB($this->pdo))->getAnswersByQuestion($questionId);

      if ($DBanswers) {
        foreach ($DBanswers as $DBanswer) {
          $question->addAnswer($DBanswer);
        }
      }

      return $question;
    }

    return false;
  }

  public function updateQuestion(array $question): bool
  {
    $this->statementUpdateOne->bindValue(":text", $question["text"]);
    $this->statementUpdateOne->bindValue(":id", $question["id"]);
    return $this->statementUpdateOne->execute();
  }

  public function deleteQuestion(int $id): bool
  {
    (new AnswerDB($this->pdo))->deleteAnswersByQuestion($id);
    $this->statementDeleteOne->bindValue(":id", $id);
    return $this->statementDeleteOne->execute();
  }

  public function deleteQuestionsByQuiz(int $quizId): bool
  {
    (new AnswerDB($this->pdo))->deleteAnswersByQuiz($quizId);
    $this->statementDeleteAllByQuiz->bindValue(":quizId", $quizId);
    return $this->statementDeleteAllByQuiz->execute();
  }
}

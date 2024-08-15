<?php

namespace App\Models\Quiz;

require_once("src/Models/Question.php");
require_once("src/Models/Answer.php");

use App\Models\Question\Question;
use App\Models\Answer\Answer;
use App\Models\Question\QuestionDB;
use App\Models\Answer\AnswerDB;

class Quiz
{
  public int $id;
  public int $authorId;
  public string $title;
  public string $description;
  public array $questions = [];

  public function __construct(array $quiz)
  {
    $this->id = $quiz["id"];
    $this->authorId = $quiz["author"];
    $this->title = $quiz["title"];
    $this->description = $quiz["description"];
  }

  public function addQuestion(Question $question)
  {
    array_push($this->questions, $question);
  }

  public function addAnswerToQuestion(int $questionId, Answer $answer)
  {
    $filteredArray = array_filter($this->questions, fn($q) => $q->id === $questionId);
    $question = array_shift($filteredArray);
    $question->addAnswer($answer);
  }
}

class QuizDB
{
  private \PDOStatement $statementCreateOne;
  private \PDOStatement $statementReadOne;
  private \PDOStatement $statementReadAll;
  private \PDOStatement $statementReadAllByAuthor;
  private \PDOStatement $statementUpdateOne;
  private \PDOStatement $statementDeleteOne;

  public function __construct(private \PDO $pdo)
  {
    $this->statementCreateOne = $pdo->prepare("
      INSERT INTO Quiz (title, author, description)
      VALUES (:title, :author, :description);
    ");

    $this->statementReadOne = $pdo->prepare("
      SELECT *
      FROM Quiz
      WHERE id = :quizId;
    ");

    $this->statementReadAll = $pdo->prepare("
      SELECT *
      FROM Quiz;
    ");

    $this->statementReadAllByAuthor = $pdo->prepare("
      SELECT *
      FROM Quiz
      WHERE quiz_author = :quizAuthor;
    ");

    $this->statementUpdateOne = $pdo->prepare("
      UPDATE Quiz
      SET
        title = :title,
        description = :description
      WHERE id = :id;
    ");

    $this->statementDeleteOne = $pdo->prepare("
      DELETE FROM Quiz
      WHERE id = :id;
    ");
  }

  public function createQuiz(array $quiz): bool
  {
    $this->statementCreateOne->bindValue(":title", $quiz["title"]);
    $this->statementCreateOne->bindValue(":author", $quiz["author"]);
    $this->statementCreateOne->bindValue(":description", $quiz["description"]);
    return $this->statementCreateOne->execute();
  }

  public function getQuiz(int $quizId): Quiz | false
  {
    $this->statementReadOne->bindValue(":quizId", $quizId);
    $this->statementReadOne->execute();

    if (($DBQuiz = $this->statementReadOne->fetch())) {
      $quiz = new Quiz($DBQuiz);

      $DBQuestions = (new QuestionDB($this->pdo))->getQuestionsByQuiz($quizId);

      if ($DBQuestions) {
        foreach ($DBQuestions as $DBQuestion) {
          $quiz->addQuestion($DBQuestion);
        }
      }

      return $quiz;
    }

    return false;
  }

  public function getAllQuiz(): array | false
  {
    $this->statementReadAll->execute();

    if (($DBQuiz = $this->statementReadAll->fetchAll())) {
      $quizList = [];
      foreach ($DBQuiz as $quiz) {
        array_push($quizList, (new Quiz($quiz)));
      }

      return $quizList;
    }

    return false;
  }

  public function getQuizByUser(int $quizAuthor): array | false
  {
    $this->statementReadAllByAuthor->bindValue(":quizAuthor", $quizAuthor);
    $this->statementReadAllByAuthor->execute();

    if (($DBQuiz = $this->statementReadAllByAuthor->fetchAll())) {
      $quizList = [];
      foreach ($DBQuiz as $quiz) {
        array_push($quizList, (new Quiz($quiz)));
      }

      return $quizList;
    }

    return false;
  }

  public function updateQuiz(array $quiz): bool
  {
    $this->statementUpdateOne->bindValue(":quizId", $quiz["id"]);
    $this->statementUpdateOne->bindValue(":title", $quiz["title"]);
    $this->statementUpdateOne->bindValue(":description", $quiz["description"]);
    return $this->statementUpdateOne->execute();
  }

  public function deleteQuiz(int $quizId): bool
  {
    (new QuestionDB($this->pdo))->deleteQuestionsByQuiz($quizId);
    $this->statementDeleteOne->bindValue(":id", $quizId);
    return $this->statementDeleteOne->execute();
  }
}

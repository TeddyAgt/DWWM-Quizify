<?php

namespace App\Models\Quiz;

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

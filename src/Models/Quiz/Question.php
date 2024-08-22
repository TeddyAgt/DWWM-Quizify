<?php

namespace App\Models\Quiz;

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
    }

    public function randomizeAnswers()
    {
        shuffle($this->answers);
    }
}

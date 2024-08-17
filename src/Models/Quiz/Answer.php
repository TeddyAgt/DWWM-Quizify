<?php

namespace App\Models\Quiz;

class Answer
{
    public int $id;
    public string $text;
    public bool $isTrue;

    public function __construct(array $answer)
    {
        $this->id = $answer["id"];
        $this->text = $answer["text"];
        $this->isTrue = !!$answer["is_true"];
    }
}

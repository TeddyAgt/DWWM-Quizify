<?php

namespace App\Models\Quiz;

class Score
{
    public int $id;
    public array $quiz;
    public array $player;
    public float $score;
    public string $date;

    public function __construct(array $score)
    {
        $this->id = $score["id"];
        $this->quiz = [
            "id" => $score["quiz_id"],
            "title" => $score["title"],
            "author" => $score["author"]
        ];
        $this->player = [
            "id" => $score["quiz_player"],
            "username" => $score["username"]
        ];
        $this->score = $score["score"];
        $this->date = $score["date"];
    }
}
